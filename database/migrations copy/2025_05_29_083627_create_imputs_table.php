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
        Schema::create('imputs', function (Blueprint $table) {
            $table->id();
            $table->integer('id_admin_imput')->nullable();
            $table->integer('id_user_imput')->nullable();
            $table->uuid('id_plan_affaire')->nullable();
            $table->date('date_imput')->nullable();
            $table->text('motif_imput')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imputs');
    }
};
