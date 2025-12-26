<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    // Nom de la table (corrigé pour enlever l'espace final)
    protected $table = 'regions';
    protected $primaryKey = 'id_region';

    public $timestamps = false;
    protected $fillable = [
        'id_region',
        'nom_region',
        'description',
        'localisation',
        'superficie',
        'population',
    ];
}
