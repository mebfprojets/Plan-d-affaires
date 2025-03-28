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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('statut')->nullable()->default(true);
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_password_changed_at')->nullable();
            $table->unsignedBigInteger('id_user_created')->nullable();
            $table->unsignedBigInteger('id_user_updated')->nullable();
            $table->unsignedBigInteger('id_user_deleted')->nullable();
            $table->foreign('id_user_created')->references('id')->on('admins')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_user_updated')->references('id')->on('admins')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_user_deleted')->references('id')->on('admins')->onDelete('set null')->onUpdate('cascade');
            $table->rememberToken();
            $table->softDeletes();

            $table->index('name');
            $table->index('email');
            $table->index('statut');
            $table->index('email_verified_at');
            $table->index('last_login_at');
            $table->index('last_password_changed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
