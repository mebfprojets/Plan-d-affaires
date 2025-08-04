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
        Schema::create('chiffre_affaire_five_years', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_plan_affaire')->nullable();
            $table->string('produit')->nullable();
            $table->double('first_year')->nullable();
            $table->double('second_year')->nullable();
            $table->double('third_year')->nullable();
            $table->double('four_year')->nullable();
            $table->double('five_year')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chiffre_affaire_five_years');
    }
};
