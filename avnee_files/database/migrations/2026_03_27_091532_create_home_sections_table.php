<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_id')->unique(); // 'just_in_1', 'just_in_2', 'best_buys', etc.
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('image')->nullable();
            $table->json('product_ids')->nullable(); // For sections like best buys where we pick products
            $table->integer('limit')->default(8);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};
