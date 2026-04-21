<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Communaute extends Model
{
    //communzute:association/daara 

    protected $fillable = [
        'numerocommu',
        'nom',
        'description'
    ];
    public function Cellules()
    {
        return $this->hasMany(Cellule::class);
    }
    public function membres()
    {
        return $this->hasMany(Users::class);
    }
    public function evenement()
    {
        return $this->hasMany(Evenement::class);
    }
    
}
