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
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('libelle')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->unsignedBigInteger('id_user_deleted')->nullable();
            $table->foreign('id_user_created')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_user_updated')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_user_deleted')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
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
