<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vérifier si la colonne n'existe pas déjà
        if (!Schema::hasColumn('contenu', 'id_type_contenu')) {
            Schema::table('contenu', function (Blueprint $table) {
                $table->foreignId('id_type_contenu')->after('id_langue');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenu', function (Blueprint $table) {
            $table->dropForeign(['id_type_contenu']);
            $table->dropColumn('id_type_contenu');
        });
    }
};
