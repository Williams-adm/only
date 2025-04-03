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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('sku', length: 10)->unique();
            $table->string('name', length: 80);
            $table->text('description')->nullable();
            /* $table->decimal('price', total:8 , places:2);
            $table->integer('stock')->unsigned()->default(0); */

            $table->foreignId('sub_category_id')->constrained()->cascadeOnDelete();

            $table->unique(['name', 'sub_category_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
