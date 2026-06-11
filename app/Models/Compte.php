<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    protected $fillable = [
        'numerocompte',
        'user_id',
        'montant_total',
        'montantotalsas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function compteusers()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function eventCompte(){
        return $this->hasMany(Cotisation::class, 'membre_id', 'user_id');
    }


  
}
