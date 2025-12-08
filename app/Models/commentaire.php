<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class commentaire extends Model
{
        protected $table = 'commentaire';
    protected $primaryKey = 'id_commentaire';

    public $timestamps = false;
    protected $fillable = [
        'id_commentaire',
        'date',
        'id_utilisateur',
        'id_contenu',
        'texte',
        'note',
    ];
}
