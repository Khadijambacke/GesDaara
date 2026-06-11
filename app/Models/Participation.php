<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = [
        'user_id',
        'evenement_id',
        'montant_total_prevu',
        'montant_paye',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'evenement_id');
    }
}
