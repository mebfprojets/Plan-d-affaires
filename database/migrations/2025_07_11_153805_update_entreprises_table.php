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
        Schema::table('entreprises', function (Blueprint $table) {
            $table->string('adresse_entreprise')->nullable();
            $table->string('email_entreprise')->nullable();
            $table->string('tel_entreprise')->nullable();
            $table->text('atout_promoteur')->nullable();
            $table->text('presentation_entreprise')->nullable();
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
