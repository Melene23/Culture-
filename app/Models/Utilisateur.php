<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateur';
    protected $primaryKey = 'id_utilisateur';
    public $timestamps = false;

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
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    // Méthode pour Laravel (reconnaître mot_de_passe)
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    // AJOUTEZ SEULEMENT CES 3 MÉTHODES :
    
    public function isAdmin()
    {
        // Vérifiez dans votre table roles quel id correspond à 'admin'
        // Si vous ne savez pas, mettez temporairement :
        return $this->id_role == 1; // À vérifier !
    }
    
    
    // Relation avec le rôle
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
    
    // Relation avec les contenus
    public function contenus()
    {
        return $this->hasMany(Contenu::class, 'id_auteur', 'id_utilisateur');
    }
}

