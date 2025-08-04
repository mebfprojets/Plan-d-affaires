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
        Schema::create('chiffre_affaire_first_years', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_plan_affaire')->nullable();
            $table->string('produit')->nullable();
            $table->double('quantite')->nullable();
            $table->double('capacite_accueil')->nullable();
            $table->double('taux_occupation')->nullable();
            $table->double('prix_unitaire')->nullable();
            $table->double('ca_mensuel')->nullable();
            $table->double('ca_annuel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chiffre_affaire_first_years');
    }
};
