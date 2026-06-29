<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        // Get commissions for the user's community
        $commissions = Commission::where('communaute_id', $user->communaute_id)
            ->with(['users' => function ($q) {
                $q->withPivot('statut');
            }])
            ->get();

        // If the user is admin, owner, or responsible, they also need to see pending requests
        $isManager = in_array($user->role, ['admin', 'owner', 'responsable', 'responsble']);
        $pendingRequests = [];

        if ($isManager) {
            // Find all pending requests in the commissions of this community
            foreach ($commissions as $commission) {
                foreach ($commission->users as $u) {
                    if ($u->pivot->statut === 'en_attente') {
                        $pendingRequests[] = [
                            'commission' => $commission,
                            'user' => $u,
                            'pivot_id' => $u->pivot->id
                        ];
                    }
                }
            }
        }

        return view('commissions.index', compact('commissions', 'pendingRequests', 'isManager'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'owner'])) {
            abort(403);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = $validated;
        $data['communaute_id'] = $user->communaute_id;

        Commission::create($data);

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Commission créée avec succès.');
    }

    public function join(Request $request, $id)
    {
        $user = Auth::user();
        $commission = Commission::where('communaute_id', $user->communaute_id)->findOrFail($id);

        // Check if the user is already in the commission
        $existing = $commission->users()->where('user_id', $user->id)->first();
        if ($existing) {
            if ($existing->pivot->statut === 'rejete') {
                // If rejected, allow them to re-apply
                $commission->users()->updateExistingPivot($user->id, ['statut' => 'en_attente']);
                return redirect()->route('admin.commissions.index')
                    ->with('success', 'Votre demande d\'adhésion a été renvoyée.');
            }
            return redirect()->route('admin.commissions.index')
                ->with('error', 'Vous avez déjà une demande en cours ou êtes déjà membre de cette commission.');
        }

        // Attach with pending status
        $commission->users()->attach($user->id, ['statut' => 'en_attente']);

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Votre demande d\'adhésion a été envoyée.');
    }

    public function approve(Request $request, $commissionId, $userId)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'owner', 'responsable', 'responsble'])) {
            abort(403);
        }

        $commission = Commission::where('communaute_id', $user->communaute_id)->findOrFail($commissionId);
        $commission->users()->updateExistingPivot($userId, ['statut' => 'approuve']);

        return redirect()->route('admin.commissions.index')
            ->with('success', 'La demande d\'adhésion a été approuvée.');
    }

    public function reject(Request $request, $commissionId, $userId)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin', 'owner', 'responsable', 'responsble'])) {
            abort(403);
        }

        $commission = Commission::where('communaute_id', $user->communaute_id)->findOrFail($commissionId);
        $commission->users()->updateExistingPivot($userId, ['statut' => 'rejete']);

        return redirect()->route('admin.commissions.index')
            ->with('success', 'La demande d\'adhésion a été rejetée.');
    }

    public function leave($id)
    {
        $user = Auth::user();
        $commission = Commission::where('communaute_id', $user->communaute_id)->findOrFail($id);
        
        $commission->users()->detach($user->id);

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Vous avez quitté la commission.');
    }
}
