<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    protected $table = 'contenu';
    protected $primaryKey = 'id_contenu';
    public $timestamps = false;

    protected $fillable = [
        'titre',
        'id_region',
        'date_creation',
        'texte',
        'statut',
        'id_langue',
        'id_auteur',
        'date_validation',
        'id_moderateur',
        'parent_id',
        'id_type_contenu',
    ];

    // AJOUTEZ CETTE MÉTHODE SEULEMENT :
    
    // Relation avec l'auteur
    public function auteur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_auteur', 'id_utilisateur');
    }
    
    // Relation avec la région
    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region', 'id_region');
    }
    
    // Relation avec la langue
    public function langue()
    {
        return $this->belongsTo(Langue::class, 'id_langue', 'id_langue');
    }
    
    // Relation avec les médias
    public function media()
    {
        return $this->hasMany(\App\Models\media::class, 'id_contenu', 'id_contenu');
    }
}