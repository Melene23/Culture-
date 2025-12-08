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
        Schema::table('contenu', function (Blueprint $table) {
            // Rendre les champs optionnels nullable
            $table->date('date_validation')->nullable()->change();
            $table->foreignId('id_moderateur')->nullable()->change();
            $table->foreignId('parent_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contenu', function (Blueprint $table) {
            // Remettre les champs comme non-nullable (attention: peut causer des erreurs si des données null existent)
            $table->date('date_validation')->nullable(false)->change();
            $table->foreignId('id_moderateur')->nullable(false)->change();
            $table->foreignId('parent_id')->nullable(false)->change();
        });
    }
};
