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
        Schema::create('saree_edit_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('INSTANT SAREE™');
            $table->string('subtitle')->default('Introducing');
            $table->text('description')->nullable();
            $table->string('main_image')->nullable();
            $table->string('detail_image_1')->nullable();
            $table->string('detail_image_2')->nullable();
            $table->string('detail_image_3')->nullable();
            $table->string('button_text')->default('PRE-DRAPE NOW');
            $table->string('button_link')->default('/products?category=sarees');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saree_edit_settings');
    }
};
