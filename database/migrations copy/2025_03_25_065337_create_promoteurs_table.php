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
        Schema::create('promoteurs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->integer('id_entreprise')->nullable();
            $table->string('age')->nullable();
            $table->integer('id_sexe')->nullable();
            $table->integer('id_situation_famille')->nullable();
            $table->string('domicile')->nullable();
            $table->string('adresse')->nullable();
            $table->string('niveau_formation')->nullable();
            $table->string('experience_secteur_activite')->nullable();
            $table->string('activite_actuelle')->nullable();
            $table->text('motivation_creation')->nullable();
            $table->text('garantie_aval')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promoteurs');
    }
};
