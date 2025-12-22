<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $renames = [
            'region' => 'regions',
            'langue' => 'langues',
            'utilisateur' => 'utilisateurs',
            'contenu' => 'contenus',
            'media' => 'medias',
            'commentaire' => 'commentaires',
            '_type_contenue' => 'type_contenus',
            '_type_media' => 'type_medias',
        ];

        foreach ($renames as $from => $to) {
            if (Schema::hasTable($from) && !Schema::hasTable($to)) {
                Schema::rename($from, $to);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $renames = [
            'regions' => 'region',
            'langues' => 'langue',
            'utilisateurs' => 'utilisateur',
            'contenus' => 'contenu',
            'medias' => 'media',
            'commentaires' => 'commentaire',
            'type_contenus' => '_type_contenue',
            'type_medias' => '_type_media',
        ];

        foreach ($renames as $from => $to) {
            if (Schema::hasTable($from) && !Schema::hasTable($to)) {
                Schema::rename($from, $to);
            }
        }
    }
};
