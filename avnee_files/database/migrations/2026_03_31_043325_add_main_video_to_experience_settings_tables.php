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
        Schema::table('saree_edit_settings', function (Blueprint $table) {
            $table->string('main_video')->nullable()->after('main_image');
        });

        Schema::table('jewellery_experience_settings', function (Blueprint $table) {
            $table->string('main_video')->nullable()->after('main_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saree_edit_settings', function (Blueprint $table) {
            $table->dropColumn('main_video');
        });

        Schema::table('jewellery_experience_settings', function (Blueprint $table) {
            $table->dropColumn('main_video');
        });
    }
};
