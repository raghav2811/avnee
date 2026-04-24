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
        Schema::table('categories', function (Blueprint $バランス) {
            if (!Schema::hasColumn('categories', 'show_in_site_header')) {
                $バランス->boolean('show_in_site_header')->default(false)->after('show_in_menu');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $バランス) {
            $バランス->dropColumn('show_in_site_header');
        });
    }
};
