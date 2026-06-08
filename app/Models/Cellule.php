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
        'communaute_id',
        'registration_token',
    ];
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($cellule) {
            if (empty($cellule->registration_token)) {
                $cellule->registration_token = \Illuminate\Support\Str::random(32);
            }
        });
    }

    public function communaute()
    {
        return $this->belongsTo(Communaute::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
}