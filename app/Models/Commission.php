<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'communaute_id',
    ];

    public function communaute()
    {
        return $this->belongsTo(Communaute::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('statut')
            ->withTimestamps();
    }
}
