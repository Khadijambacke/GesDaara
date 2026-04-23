<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    //
    protected $fillable = [
        'numeroevent',
        'objectifmontant',
        'cotisations',
        'montantotalparticipe',
        'datedebut',
        'datefin',
        'communaute_id',
    ];
    ////une communaute peut enregister plusieurs evenement et un  evenenment est lier a une communaute
   
    public function communaute()
    {
        return $this->belongsTo(Communaute::class,  'communaute_id');
    }
    public function transactions()
    {
        return $this->belongsTo(Transaction::class);
    }
   
    
}
