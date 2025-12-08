<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class media extends Model
{
     protected $table = 'media';
    protected $primaryKey = 'id_media';

    public $timestamps = false;
    protected $fillable = [
        'id_meidia',
        'chemin',
        'description',
        'id_contenu',
        'id_type_media',
        
    ];
    
    // Relation avec le type de média
    public function typeMedia()
    {
        return $this->belongsTo(TypeMedia::class, 'id_type_media', 'id_type_media');
    }
}
