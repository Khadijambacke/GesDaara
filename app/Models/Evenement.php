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
        'datecloture',
        'statut',
        'communaute_id',
        'cellule_id',
    ];
    ////une communaute peut enregister plusieurs evenement et un  evenenment est lier a une communaute
   
    public function communaute()
    {
        return $this->belongsTo(Communaute::class,  'communaute_id');
    }

    public function cellule()
    {
        return $this->belongsTo(Cellule::class, 'cellule_id');
    }

    public function cotisationsRelation()
    {
        return $this->hasMany(Cotisation::class, 'evenement_id');
    }
    public function participationsRelation()
    {
        return $this->hasMany(Participation::class, 'evenement_id');
    }
    public function transactions()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function participation(){
        return $this->hasMany(Participation::class);
    }
   
    
}
