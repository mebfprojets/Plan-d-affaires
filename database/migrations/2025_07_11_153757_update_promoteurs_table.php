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
        Schema::table('promoteurs', function (Blueprint $table) {
            $table->boolean('is_porteur')->default(false);
            $table->string('nom_promoteur')->nullable();
            $table->string('prenom_promoteur')->nullable();
            $table->string('tel_promoteur')->nullable();
            $table->string('email_promoteur')->nullable();
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
