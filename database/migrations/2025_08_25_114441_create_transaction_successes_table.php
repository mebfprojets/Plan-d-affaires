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
        Schema::create('transaction_successes', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_plan_affaire');
            $table->string('response_code')->nullable();
            $table->text('token')->nullable();
            $table->string('response_text')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->nullable();
            $table->string('operator_id')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('customer')->nullable();
            $table->string('wiki')->nullable();
            $table->double('montant')->nullable();
            $table->double('amount')->nullable();
            $table->datetime('date')->nullable();
            $table->string('external_id')->nullable();
            $table->string('oreference')->nullable();
            $table->string('customer_firstname')->nullable();
            $table->string('customer_lastname')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_details')->nullable();
            $table->string('request_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_successes');
    }
};
