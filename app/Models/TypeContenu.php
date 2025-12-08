<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeContenu extends Model
{
    protected $table = '_type_contenue';
    protected $primaryKey = 'id_type_contenu';
 public $timestamps = false;

    protected $fillable = [
        'id_type_contenu',
        'nom_contenu',
       
    ];
}
