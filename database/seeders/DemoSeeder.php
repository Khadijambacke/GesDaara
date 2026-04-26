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
        $cellule3=Cellule::create([
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
             'prenom'   => 'Khadija Mbacké',
            'telephone'=> 771234567,
            'adresse`'   => 'Dakar',
            'photo'    => null,
            'role'    => 'admin', 
            'communaute_id' =>$commu1->id,
            'cellule_id'    => $cellule1->id
            
           
        ]);
       
    }
}
