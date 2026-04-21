<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'numero',
        'libelle',
        'description',
        'montanttr',
        'methode_transactions',
        'typeTransctions',
        'justificatif',
        'users_id',
        'evenement_id'
    ];
   
    public function users()
    {
        return $this->belongsTo(Users::class,  'communaute_id');
    }
    
    public function evenements()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }
}
