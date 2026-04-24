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
        Schema::create('brand_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            $table->string('layout_type')->nullable(); // layout_1, layout_2
            $table->string('title')->nullable(); // Upper heading
            $table->string('content_title')->nullable(); // Big pinkish title
            $table->text('content_description')->nullable();
            
            $table->string('image_1')->nullable();
            $table->string('image_1_label')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_2_label')->nullable();
            $table->string('image_3')->nullable();
            $table->string('image_3_label')->nullable();
            $table->string('image_4')->nullable();
            $table->string('image_4_label')->nullable();
            
            $table->string('button_text')->default('SHOP NOW');
            $table->string('button_link')->nullable();
            
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_experiences');
    }
};
