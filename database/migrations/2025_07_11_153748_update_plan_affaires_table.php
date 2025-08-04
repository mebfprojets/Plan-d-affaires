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
            $table->text('business_titre')->nullable();
            $table->text('caractere_innovant_projet')->nullable();
            $table->double('cout_total_projet')->nullable();
            $table->double('apport_personnel')->nullable();
            $table->text('etude_marche')->nullable();
            $table->text('etude_demande')->nullable();
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
