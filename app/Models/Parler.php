<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parler extends Model
{
    protected $table = 'parler';
    public $timestamps = false;

    protected $fillable = [
        'id_region',
        'id_langue',
    ];

    // --- Relations ---
    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region');
    }

    public function langue()
    {
        return $this->belongsTo(Langue::class, 'id_langue');
    }
}
