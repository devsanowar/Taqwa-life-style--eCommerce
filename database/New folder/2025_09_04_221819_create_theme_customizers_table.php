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
        Schema::create('theme_customizers', function (Blueprint $table) {
            $table->id();

            $table->enum('theme_style', [
                'light-theme',
                'dark-theme',
                'semi-dark',
                'minimal-theme'
            ])->default('minimal-theme');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_customizers');
    }
};
