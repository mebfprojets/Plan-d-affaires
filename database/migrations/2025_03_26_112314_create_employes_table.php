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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_plan_affaire')->nullable();
            $table->string('poste')->nullable();
            $table->string('qualification')->nullable();
            $table->integer('effectif')->nullable();
            $table->double('salaire_mensuel')->nullable();
            $table->text('tache_prevu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
