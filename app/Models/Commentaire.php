<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaires';
    protected $primaryKey = 'id_commentaire';

    public $timestamps = true;
    protected $fillable = [
        'id_commentaire',
        'date',
        'id_utilisateur',
        'id_contenu',
        'texte',
        'note',
    ];
}
