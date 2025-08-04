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
        Schema::table('chiffre_affaire_first_years', function (Blueprint $table) {
            $table->renameColumn('capacite_accueil', 'unite_first');
            $table->renameColumn('taux_occupation', 'chiffre_affaire_first');
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
