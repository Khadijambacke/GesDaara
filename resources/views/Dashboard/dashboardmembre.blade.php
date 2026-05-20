<!-- resources/views/Dashboard/dashboardmembre.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard Membre')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Bienvenue, {{ Auth::user()->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Upcoming Events -->
        <section class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-semibold mb-2">Événements à venir</h2>
            @if($evenementsActifs ?? false)
                <ul class="list-disc pl-5">
                @foreach($evenementsActifs as $event)
                    <li>{{ $event->numeroevent }} – {{ $event->datedebut->format('d/m/Y') }}</li>
                @endforeach
                </ul>
            @else
                <p class="text-gray-600">Aucun événement prévu.</p>
            @endif
        </section>

        <!-- Recent Contributions -->
        <section class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-semibold mb-2">Dernières cotisations</h2>
            @if($dernieresCotisations ?? false && $dernieresCotisations->count())
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="pb-2">Date</th>
                            <th class="pb-2">Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($dernieresCotisations as $cot)
                        <tr class="border-b">
                            <td class="py-1">{{ $cot->created_at->format('d/m/Y') }}</td>
                            <td class="py-1">{{ number_format($cot->montantcotise, 2) }} FCFA</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-600">Pas de cotisations récentes.</p>
            @endif
        </section>
    </div>
</div>
@endsection
