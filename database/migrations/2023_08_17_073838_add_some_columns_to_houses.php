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
        Schema::table('houses', function (Blueprint $table) {
            $table->foreignId('house_components_id')->constrained('house_components')->cascadeOnDelete();
            $table->foreignId('home_amenities_id')->constrained('home_amenities')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropForeign(['house_components_id']);
            $table->dropForeign(['home_amenities_id']);
        });
    }
};
