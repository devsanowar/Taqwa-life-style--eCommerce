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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_title')->nullable();
            $table->string('website_header_logo')->nullable();
            $table->string('website_favicon')->nullable();
            $table->string('website_footer_logo')->nullable();
            $table->string('website_phone_number_one')->nullable();
            $table->string('website_phone_number_two')->nullable();
            $table->string('website_email_one')->nullable();
            $table->string('website_email_two')->nullable();
            $table->string('website_address')->nullable();
            $table->text('website_footer_content')->nullable();
            $table->text('website_copyright_text')->nullable();
            $table->string('website_footer_bg_image')->nullable();
            $table->string('website_footer_bg_color')->nullable();
            $table->string('website_website_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
