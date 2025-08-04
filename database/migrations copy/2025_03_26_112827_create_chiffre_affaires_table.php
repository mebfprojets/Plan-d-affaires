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
        Schema::create('chiffre_affaires', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_plan_affaire')->nullable();
            $table->string('designation')->nullable();
            $table->double('unite')->nullable();
            $table->double('quantite')->nullable();
            $table->double('prix_unitaire')->nullable();
            $table->double('montant')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chiffre_affaires');
    }
};
