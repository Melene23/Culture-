<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeMedia extends Model
{
    protected $table = '_type_media';
    protected $primaryKey = 'id_type_media';
 public $timestamps = false;

    protected $fillable = [
        'id_type_media',
        'nom_media',
       
    ];
}
