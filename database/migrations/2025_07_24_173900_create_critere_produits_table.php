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
        Schema::create('critere_produits', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_plan_affaire')->nullable();
            $table->integer('id_produit')->nullable();
            $table->integer('id_valeur')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('critere_produits');
    }
};
