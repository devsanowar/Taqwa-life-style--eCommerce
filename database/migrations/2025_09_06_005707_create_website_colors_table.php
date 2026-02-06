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
        Schema::create('website_colors', function (Blueprint $table) {
            $table->id();

            // Fonts
            $table->string('font_primary')->default('"Poppins", sans-serif');
            $table->string('font_secondary')->default('"Rubik", sans-serif');

            // Colors
            $table->string('gray')->default('#585b6b');
            $table->string('gray_rgb')->default('88, 91, 107');

            $table->string('base')->default('#FD5523');
            $table->string('base_rgb')->default('253, 85, 35');

            $table->string('primary')->default('#F4F5F9');
            $table->string('primary_rgb')->default('244, 245, 249');

            $table->string('black')->default('#062f3a');
            $table->string('black_rgb')->default('6, 47, 58');

            $table->string('white')->default('#ffffff');
            $table->string('white_rgb')->default('255, 255, 255');

            // Border
            $table->string('border_color')->default('#e6e6e6');
            $table->string('border_color_rgb')->default('230, 230, 230');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_colors');
    }
};
