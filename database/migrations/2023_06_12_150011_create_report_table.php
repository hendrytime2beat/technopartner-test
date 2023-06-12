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
        Schema::create('tb_report', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaction')->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->enum('transaction_type', ['income', 'expenditure'])->nullable();
            $table->integer('expenditure')->default(0);
            $table->integer('income')->default(0);
            $table->integer('saldo')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_report');
    }
};
