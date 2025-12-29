<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('medias')) {
            return;
        }

        Schema::table('medias', function (Blueprint $table) {
            if (!Schema::hasColumn('medias', 'id_contenu')) {
                $table->unsignedBigInteger('id_contenu')->nullable()->after('description');
            }
        });

        Schema::table('medias', function (Blueprint $table) {
            // Ajout FK seulement si la colonne existe et qu'on n'a pas déjà une contrainte
            if (Schema::hasColumn('medias', 'id_contenu')) {
                try {
                    $table->foreign('id_contenu')
                        ->references('id_contenu')
                        ->on('contenus')
                        ->nullOnDelete();
                } catch (\Throwable $e) {
                    // ignore (déjà existante ou driver ne permet pas la création)
                }
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('medias')) {
            return;
        }

        Schema::table('medias', function (Blueprint $table) {
            try {
                $table->dropForeign(['id_contenu']);
            } catch (\Throwable $e) {
                // ignore
            }

            if (Schema::hasColumn('medias', 'id_contenu')) {
                $table->dropColumn('id_contenu');
            }
        });
    }
};
