<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cellule extends Model
{
   ///une section de la communaute
    protected $fillable = [
        'numerosection',
        'nomsection',
        'localite',

    ];
    public function communaute()
    {
        return $this->belongsTo(Communaute::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
}