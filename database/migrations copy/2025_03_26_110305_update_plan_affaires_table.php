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
        Schema::table('plan_affaires', function (Blueprint $table) {
            $table->integer('id_entreprise')->nullable();
            $table->text('produit_service')->nullable(); // Demander si on doit détailler?
            $table->text('situation_secteur_activite')->nullable();
            $table->text('evaluation_marche_potentiel')->nullable();
            $table->text('profil_marche_cible')->nullable();
            $table->text('marche_vise')->nullable();
            $table->text('situation_concurrentielle')->nullable();
            $table->text('analyse_concurrentielle')->nullable();
            $table->text('politique_produit')->nullable();
            $table->text('politique_prix')->nullable();
            $table->text('politique_promotion')->nullable();
            $table->text('politique_distribution')->nullable();
            $table->text('description_infrastructure')->nullable();
            $table->text('description_equipement')->nullable();
            $table->text('description_process')->nullable();
            $table->text('processus_production')->nullable();
            $table->text('reglementation')->nullable();

            // DOSSIER FINANCIER
            $table->text('estimation_chiffre_affaire')->nullable();
            $table->double('montant_emprunt')->nullable();
            $table->integer('nombre_year_remb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
