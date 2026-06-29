<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Communaute;
use App\Models\Cellule;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commu1 = Communaute::create([
            'numerocommu' => 0001,
             'nom' => 'Toubacakaname',
             'description' => 'Daara des murids pour le 
             service de touba',
        ]);
        $commu2 = Communaute::create([
             'numerocommu' => 0002,
              'nom' => 'Mouhadimatul xidma',
            'description' => 'Mouhadimatul xidma de touba',
         ]);

         $cellule1=Cellule::create([
            'numerosection' => 0011,
            'nomsection' => 'Section dakar',
            'localite' => 'Dakar',
            'communaute_id' =>$commu1 ->id
          ]);
            $cellule4=Cellule::create([
            'numerosection' => 0011,
            'nomsection' => 'Section Mbour',
            'localite' => 'Dakar',
            'communaute_id' =>$commu1 ->id
          ]);

          $cellule2=Cellule::create([
            'numerosection' => 0012,
            'nomsection' => 'Section Touba',
            'localite' => 'Touba',
            'communaute_id' =>$commu1->id
        ]);
        $cellule3=Cellule::create([
            'numerosection' => 00013,
            'nomsection' => 'Section Darou miname',
            'localite' => 'Touba',
            'communaute_id' =>$commu1->id
        ]);
        $cellule4=Cellule::create([
            'numerosection' => 00014,
            'nomsection' => 'Section Touba pikine',
            'localite' => 'Pikine',
            'communaute_id'=>$commu2->id
        ]);
        $admin = User::create([

            'Nom' => 'Mbacké',
            'email'    => 'momyna@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
             'prenom'   => 'Momynatou',
            'telephone'=> 771234567,
            'adresse'   => 'Dakar',
            'photo'    => null,
            'role'    => 'admin', 
            'communaute_id' =>$commu1->id,
            'cellule_id'    => $cellule1->id
        ]);
        $membre1 = User::create([

            'Nom' => 'Diop',
            'email'    => 'khadija@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('membre123'),
             'prenom'   => 'Khadija',
            'telephone'=> 778976556,
            'adresse'   => 'Touba',
            'photo'    => null,
            'role'    => 'membre', 
            'communaute_id' =>$commu1->id,
            'cellule_id'    => $cellule2->id
        ]);
        $membre2 = User::create([

            'Nom' => 'Hanne',
            'email'    => 'marie@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('membre124'),
             'prenom'   => 'marie',
            'telephone'=> 778998356,
            'adresse'   => 'Dakar',
            'photo'    => null,
            'role'    => 'membre', 
            'communaute_id' =>$commu1->id,
            'cellule_id'    => $cellule1->id
        ]);
        $membre3 = User::create([

            'Nom' => 'Ndiaye',
            'email'    => 'jaarah@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('membre125'),
             'prenom'   => 'Jarriatulah',
            'telephone'=> 778921356,
            'adresse'   => 'Dakar',
            'photo'    => null,
            'role'    => 'membre', 
            'communaute_id' =>$commu1->id,
            'cellule_id'    => $cellule1->id
        ]);
        $responsable = User::create([
            'Nom' => 'Fall',
            'email'    => 'sokhna@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('membre126'),
             'prenom'   => 'sokhna',
            'telephone'=> 778912356,
            'adresse'   => 'Dakar',
            'photo'    => null,
            'role'    => 'responsble', 
            'communaute_id' =>$commu1->id,
            'cellule_id'    => $cellule1->id
        ]);

        // Commissions
        \App\Models\Commission::create([
            'nom' => 'Commission Culturelle',
            'description' => 'Chargée de l\'enseignement religieux, de l\'organisation des conférences et des chants religieux (Dahiras).',
            'communaute_id' => $commu1->id
        ]);
        \App\Models\Commission::create([
            'nom' => 'Commission Organisation',
            'description' => 'Gère la logistique, la sonorisation, l\'accueil des invités et la restauration lors des événements.',
            'communaute_id' => $commu1->id
        ]);
        \App\Models\Commission::create([
            'nom' => 'Commission Finance',
            'description' => 'Responsable du suivi des cotisations, de la comptabilité générale et de la validation des dépenses.',
            'communaute_id' => $commu1->id
        ]);
    }
}
