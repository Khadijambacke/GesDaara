<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nom',
        'email',
        'prenom',
        'telephone',
        'password',
        'role',
        'adresse',
        'photo',
        'communaute_id',
        'cellule_id',
        'type_membre',
        'genre',
        'nom_pere',
        'nom_mere',
        'nin',
        'profession',
        'etablissement_scolaire',
        'niveau_etudes',
        'parent_tuteur_nom',
        'parent_tuteur_telephone',
        'date_naissance',
        'cgu_accepted',
        'cgu_accepted_at',
        'invitation_token',
        'matricule',
        'numero_identite',
        'situation_matrimoniale',
        'est_enfant'
    ];
    public function cellule()
    {
        return $this->belongsTo(Cellule::class, 'cellule_id');
    }
    
    public function getNameAttribute()
    {
        return ($this->Prenom ?? $this->prenom) . ' ' . ($this->Nom ?? $this->nom);
    }
public function transactions()
{
    return $this->hasMany(Transaction::class);
}


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_naissance' => 'date',
            'cgu_accepted_at' => 'datetime',
            'cgu_accepted' => 'boolean',
            'est_enfant' => 'boolean',
        ];
    }
}
