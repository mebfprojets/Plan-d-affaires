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
        Schema::create('session_formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id') // Colonne clé étrangère pour `formations`
                ->nullable()
                ->constrained('formations')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->string('startdate')->nullable();
            $table->string('enddate')->nullable();
            $table->string('duree_formation')->nullable();
            $table->string('lieu_formation')->nullable();
            $table->double('prix_formation')->nullable();
            $table->foreignId('id_user_created') // Colonne clé étrangère pour `users`
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('id_user_updated') // Colonne clé étrangère pour `users`
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('id_user_deleted') // Colonne clé étrangère pour `users`
                ->nullable()
                ->constrained('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->softDeletes(); // Ajoute une colonne `deleted_at` pour la suppression douce
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_formations');
    }
};
