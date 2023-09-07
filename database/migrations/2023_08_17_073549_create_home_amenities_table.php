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
        Schema::create('home_amenities', function (Blueprint $table) {
            $table->id();
            $table->string('additional')->nullable();
            $table->boolean('bus_stop')->default(false);
            $table->boolean('garden')->default(false);
            $table->boolean('market')->default(false);
            $table->boolean('park')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('school')->default(false);
            $table->boolean('stadium')->default(false);
            $table->boolean('subway')->default(false);
            $table->boolean('super_market')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_amenities');
    }
};
