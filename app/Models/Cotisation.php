<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    protected $fillable = [
        'numerocontributions',
        'montantcotise',
        'methodepayement',
        'datecotisations',
        'evenement_id',
        'membre_id',

    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'membre_id');
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($cotisation) {
            $user = $cotisation->users;
            if ($user) {
                // Mettre à jour le solde du compte du membre
                $compte = $user->compte ?: $user->compte()->create([
                    'numerocompte' => 'CPTE-' . strtoupper(bin2hex(random_bytes(4))),
                    'montant_total' => 0.00,
                    'montantotalsas' => 0.00,
                ]);
                $compte->increment('montant_total', $cotisation->montantcotise);

                // Mettre à jour la participation spécifique à l'événement
                if ($cotisation->evenement_id) {
                    $participation = \App\Models\Participation::where('user_id', $user->id)
                        ->where('evenement_id', $cotisation->evenement_id)
                        ->first();

                    if ($participation) {
                        $participation->increment('montant_paye', $cotisation->montantcotise);
                    } else {
                        \App\Models\Participation::create([
                            'user_id' => $user->id,
                            'evenement_id' => $cotisation->evenement_id,
                            'montant_total_prevu' => $cotisation->montantcotise,
                            'montant_paye' => $cotisation->montantcotise,
                        ]);
                    }
                }
            }
        });
    }
    
}
