<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';  // ta table

    protected $primaryKey = 'id_utilisateur'; // ta clé primaire

    public $timestamps = false;  // si ta table n'a pas created_at/updated_at

    protected $casts = [
        'date_naissance' => 'date',
        'date_inscription' => 'datetime',
    ];

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'id_role',
        'id_langue',
        'sexe',
        'photo',
        'statut',
        'date_naissance',
        'date_inscription',
       ];


    protected $hidden = [
        'mot_de_passe',
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe; // Breeze utilise "password" → toi c'est mot_de_passe
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function hasRole($role)
    {
        return $this->role && $this->role->nom === $role;
    }
}
