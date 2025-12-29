<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';
    protected $primaryKey = 'id_media';

    public $timestamps = true;
    protected $fillable = [
        'id_media',
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

    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'id_contenu', 'id_contenu');
    }
}
