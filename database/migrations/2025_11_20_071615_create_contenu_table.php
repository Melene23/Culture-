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
        Schema::create('contenu', function (Blueprint $table) {
            $table->id('id_contenu');
            $table->string('titre');
            $table->foreignId('id_region');
            $table->date('date_creation');
            $table->text('texte');
            $table->string('statut');
            $table->foreignId('id_langue');
            $table->foreignId('id_auteur');
            
            $table->date('date_validation');
            $table->foreignId('id_moderateur');
            $table->foreignId('parent_id');
  });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenu');
    }
};
