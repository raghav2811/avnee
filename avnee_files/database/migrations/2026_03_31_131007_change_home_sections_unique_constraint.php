<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_sections', function (Blueprint $table) {
            // Drop old unique constraint on section_id (if exists as 'home_sections_section_id_unique')
            $table->dropUnique(['section_id']);
            
            // Add composite unique constraint
            $table->unique(['brand_id', 'section_id']);
        });
    }

    public function down(): void
    {
        Schema::table('home_sections', function (Blueprint $table) {
            $table->dropUnique(['brand_id', 'section_id']);
            $table->unique('section_id');
        });
    }
};
