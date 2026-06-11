<?php

namespace Tests\Feature;

use App\Models\Cellule;
use App\Models\Communaute;
use App\Models\Compte;
use App\Models\Cotisation;
use App\Models\Evenement;
use App\Models\User;
use App\Models\Participation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ParticipationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_set_participation_goal_and_cotisation_updates_it_and_compte()
    {
        // 1. Create a Communaute with required fields
        $communaute = Communaute::create([
            'numerocommu' => 1234,
            'nom' => 'Test Communaute',
            'description' => 'Test Description',
        ]);

        // 2. Create a Cellule with required fields
        $cellule = Cellule::create([
            'numerosection' => 5678,
            'nomsection' => 'Test Section',
            'localite' => 'Dakar',
            'communaute_id' => $communaute->id,
        ]);

        // 3. Create a User (which auto-creates a Compte via Model Boot event)
        $user = User::create([
            'prenom' => 'Modou',
            'nom' => 'Diop',
            'email' => 'modou@diop.com',
            'password' => Hash::make('password'),
            'role' => 'membre',
            'communaute_id' => $communaute->id,
            'cellule_id' => $cellule->id,
            'telephone' => '771234567',
            'adresse' => 'Dakar',
        ]);

        // 4. Create an Evenement
        $evenement = Evenement::create([
            'numeroevent' => 'EVT-TEST-1',
            'datedebut' => now()->toDateString(),
            'datecloture' => now()->addDays(5)->toDateString(),
            'statut' => 'En_cours',
            'objectifmontant' => 100000,
            'cotisations' => 0.00,
            'montantotalparticipe' => 0.00,
            'communaute_id' => $communaute->id,
        ]);

        // 5. Act: Simulate setting participation goal via route
        $response = $this->actingAs($user)->post(route('membre.participations.store'), [
            'evenement_id' => $evenement->id,
            'montant_total_prevu' => 50000,
        ]);

        $response->assertRedirect();
        
        // Assert participation record is created
        $this->assertDatabaseHas('participations', [
            'user_id' => $user->id,
            'evenement_id' => $evenement->id,
            'montant_total_prevu' => 50000,
            'montant_paye' => 0,
        ]);

        // 6. Act: Simulate recording a cotisation via route
        $cotisationResponse = $this->actingAs($user)->post(route('membre.cotisations.store'), [
            'montantcotise' => 15000,
            'methodepayement' => 'wave',
            'evenement_id' => $evenement->id,
        ]);

        $cotisationResponse->assertRedirect();

        // 7. Assert:
        // - Compte balance updated
        $compte = $user->compte;
        $compte->refresh();
        $this->assertEquals(15000, $compte->montant_total);

        // - Participation montant_paye updated
        $participation = Participation::where('user_id', $user->id)
            ->where('evenement_id', $evenement->id)
            ->first();
        $this->assertNotNull($participation);
        $this->assertEquals(15000, $participation->montant_paye);

        // - Evenement total updated
        $evenement->refresh();
        $this->assertEquals(15000, $evenement->montantotalparticipe);
    }

    public function test_role_based_event_show_view()
    {
        // 1. Create a Communaute
        $communaute = Communaute::create([
            'numerocommu' => 1234,
            'nom' => 'Test Communaute',
            'description' => 'Test Description',
        ]);

        // 2. Create Cellules
        $cellule1 = Cellule::create([
            'numerosection' => 5678,
            'nomsection' => 'Section Dakar',
            'localite' => 'Dakar',
            'communaute_id' => $communaute->id,
        ]);

        $cellule2 = Cellule::create([
            'numerosection' => 9999,
            'nomsection' => 'Section Thies',
            'localite' => 'Thies',
            'communaute_id' => $communaute->id,
        ]);

        // 3. Create Users with different roles
        $admin = User::create([
            'prenom' => 'Admin',
            'nom' => 'User',
            'email' => 'admin@daara.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'communaute_id' => $communaute->id,
            'adresse' => 'Dakar',
            'telephone' => '771111111',
        ]);

        $responsable = User::create([
            'prenom' => 'Responsable',
            'nom' => 'User',
            'email' => 'resp@daara.com',
            'password' => Hash::make('password'),
            'role' => 'responsable',
            'communaute_id' => $communaute->id,
            'cellule_id' => $cellule1->id,
            'adresse' => 'Dakar',
            'telephone' => '772222222',
        ]);

        $membre = User::create([
            'prenom' => 'Membre',
            'nom' => 'User',
            'email' => 'membre@daara.com',
            'password' => Hash::make('password'),
            'role' => 'membre',
            'communaute_id' => $communaute->id,
            'cellule_id' => $cellule1->id,
            'adresse' => 'Dakar',
            'telephone' => '773333333',
        ]);

        // 4. Create an Evenement
        $evenement = Evenement::create([
            'numeroevent' => 'EVT-TEST-2',
            'datedebut' => now()->toDateString(),
            'datecloture' => now()->addDays(5)->toDateString(),
            'statut' => 'En_cours',
            'objectifmontant' => 100000,
            'cotisations' => 0.00,
            'montantotalparticipe' => 0.00,
            'communaute_id' => $communaute->id,
        ]);

        // 5. Create a Cotisation for this member
        Cotisation::create([
            'numerocontributions' => 'COT-TEST-2',
            'montantcotise' => 10000,
            'methodepayement' => 'wave',
            'datecotisations' => now()->toDateString(),
            'evenement_id' => $evenement->id,
            'membre_id' => $membre->id,
        ]);

        // 6. Assert Admin sees cotisations grouped by section
        $responseAdmin = $this->actingAs($admin)->get(route('showevent', $evenement->id));
        $responseAdmin->assertStatus(200);
        $responseAdmin->assertViewHas('cotisationsParSection');

        // 7. Assert Responsable sees members in their section
        $responseResp = $this->actingAs($responsable)->get(route('showevent', $evenement->id));
        $responseResp->assertStatus(200);
        $responseResp->assertViewHas('membresSection');

        // 8. Assert Member sees their own cotisations
        $responseMembre = $this->actingAs($membre)->get(route('showevent', $evenement->id));
        $responseMembre->assertStatus(200);
        $responseMembre->assertViewHas('mesCotisations');
    }
}
