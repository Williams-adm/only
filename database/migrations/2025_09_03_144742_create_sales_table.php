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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('employee');
            $table->json('content');
            $table->time('date_transaction');
            $table->string('type_voucher', length: 20);
            $table->string('type_document', length: 20);
            $table->string('n_document', length: 11);
            $table->string('names', length: 50)->nullable();
            $table->string('razon_social', length: 80)->nullable();
            $table->string('dirección fiscal', length: 150)->nullable();
            $table->string('type_emision', length: 20);
            $table->string('methd_payment', length: 40);
            $table->decimal('paid_amount');
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
