<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Langue extends Model
{
    protected $table = 'langue';
    protected $primaryKey = 'id_langue';
 public $timestamps = false;

    protected $fillable = [
        'nom_langue',
        'code_langue',
        'description',
    ];
}
