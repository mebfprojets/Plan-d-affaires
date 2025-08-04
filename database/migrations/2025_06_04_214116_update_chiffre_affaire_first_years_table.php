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
            $table->dropColumn('unite_first');
            $table->dropColumn('chiffre_affaire_first');
            $table->string('unite_first')->nullable();
            $table->double('chiffre_affaire_first')->nullable();
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
