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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (empty($user->matricule)) {
                $year = date('Y');
                do {
                    $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                    $matricule = "SD-{$year}-{$random}";
                } while (self::where('matricule', $matricule)->exists());
                $user->matricule = $matricule;
            }
        });

        static::created(function ($user) {
            $user->compte()->create([
                'numerocompte' => 'CPTE-' . strtoupper(bin2hex(random_bytes(4))),
                'montant_total' => 0.00,
                'montantotalsas' => 0.00,
            ]);
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nom',
        'Nom',
        'email',
        'prenom',
        'Prenom',
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
    
    public function communaute()
    {
        return $this->belongsTo(Communaute::class, 'communaute_id');
    }
    
    public function getNomAttribute($value)
    {
        return $this->attributes['Nom'] ?? ($this->attributes['nom'] ?? $value);
    }

    public function setNomAttribute($value)
    {
        $this->attributes['Nom'] = $value;
    }

    public function getPrenomAttribute($value)
    {
        return $this->attributes['Prenom'] ?? ($this->attributes['prenom'] ?? $value);
    }

    public function setPrenomAttribute($value)
    {
        $this->attributes['Prenom'] = $value;
    }

    public function getNameAttribute()
    {
        return $this->Prenom . ' ' . $this->Nom;
    }
public function transactions()
{
    return $this->hasMany(Transaction::class);
}

    public function commissions()
    {
        return $this->belongsToMany(Commission::class)
            ->withPivot('statut')
            ->withTimestamps();
    }

public function compte()
{
    return $this->hasOne(Compte::class, 'user_id');
}

public function participations()
{
    return $this->hasMany(Participation::class, 'user_id');
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
