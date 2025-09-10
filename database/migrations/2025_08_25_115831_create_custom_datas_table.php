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
        Schema::create('custom_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id')->nullable();
            $table->string('keyof_customdata')->nullable();
            $table->string('valueof_customdata')->nullable();
            $table->string('datecreation_customdata')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_datas');
    }
};
