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
        Schema::create('plan_affaires', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('id_pack');
            $table->integer('id_user');
            $table->text('business_idea')->nullable();
            $table->text('business_object')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans_affaire');
    }
};
