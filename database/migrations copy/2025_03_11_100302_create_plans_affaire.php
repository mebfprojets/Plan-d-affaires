<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {

        // Table des plans d'affaires
        Schema::create('business_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('total_budget', 15, 2)->nullable();
            $table->json('financial_projections')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Table des annexes et documents
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_plan_id')->constrained('business_plans')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
        });

        // Table des graphiques et analyses
        Schema::create('analysis_charts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_plan_id')->constrained('business_plans')->onDelete('cascade');
            $table->string('chart_type');
            $table->json('data');
            $table->timestamps();
        });

        // Table des structures de financement
        Schema::create('financial_structures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        // Table de liaison entre les plans d'affaires et les structures de financement
        Schema::create('business_plan_financial_structure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_plan_id')->constrained('business_plans')->onDelete('cascade');
            $table->foreignId('financial_structure_id')->constrained('financial_structures')->onDelete('cascade');
            $table->timestamps();
        });

        // Table des notifications et assistances
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->timestamps();
        });

        // Table des messages d'assistance (chat)
        Schema::create('assistance_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('assistance_messages');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('business_plan_financial_structure');
        Schema::dropIfExists('financial_structures');
        Schema::dropIfExists('analysis_charts');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('business_plans');
        Schema::dropIfExists('users');
    }
};
