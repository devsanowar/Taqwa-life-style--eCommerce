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
        Schema::create('inventory_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_variant_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')->nullable();

            $table->integer('stock_on_hand')->default(0);
            $table->integer('stock_reserved')->default(0);
            $table->integer('reorder_level')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_balances');
    }
};