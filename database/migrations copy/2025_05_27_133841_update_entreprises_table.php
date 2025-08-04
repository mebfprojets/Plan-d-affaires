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
            $table->integer('id_region')->nullable();
            $table->integer('id_province')->nullable();
            $table->integer('id_commune')->nullable();
            $table->integer('id_arrondissement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $table->dropColumn(['id_region', 'id_province', 'id_commune', 'id_arrondissement']);
    }
};
