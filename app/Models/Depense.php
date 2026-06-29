<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $fillable = [
        'libelle',
        'montant',
        'date_depense',
        'evenement_id',
        'communaute_id',
        'justificatif',
    ];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }

    public function communaute()
    {
        return $this->belongsTo(Communaute::class);
    }
}
