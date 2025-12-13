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
            $table->date('date_creation')->default(now());
            $table->text('texte');
            $table->string('statut')->default('en attente');
            $table->foreignId('id_langue');
            $table->foreignId('id_auteur');
            
            $table->date('date_validation')->nullable();
            $table->foreignId('id_moderateur')->nullable();
            $table->foreignId('parent_id')->nullable();
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
