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
        Schema::create('valeurs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_parent')->nullable();
            $table->unsignedBigInteger('id_parametre');
            $table->string('libelle')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->unsignedBigInteger('id_user_deleted')->nullable();
            $table->foreign('id_parent')->references('id')->on('valeurs')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_parametre')->references('id')->on('parametres')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_user_deleted')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->index('id_parent');
            $table->index('id_parametre');
            $table->index('libelle');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valeurs');
    }
};
