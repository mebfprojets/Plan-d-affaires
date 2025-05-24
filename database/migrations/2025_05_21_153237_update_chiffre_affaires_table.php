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
        Schema::table('chiffre_affaires', function (Blueprint $table) {
            // Renommer une colonne
            $table->renameColumn('designation', 'produit');
            $table->renameColumn('unite', 'an_1');
            $table->renameColumn('quantite', 'an_2');
            $table->renameColumn('prix_unitaire', 'an_3');
            $table->renameColumn('montant', 'an_4');
            $table->double('an_5')->nullable();

            // Modifier le type d'une colonne (nécessite doctrine/dbal)
            $table->string('an_1')->change()->nullable();
            $table->double('an_2')->change()->nullable();
            $table->double('an_3')->change()->nullable();
            $table->double('an_4')->change()->nullable();
            $table->double('an_5')->change()->nullable();
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
