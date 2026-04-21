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
        return $this->belongsTo(User::class);
    }
    
}
