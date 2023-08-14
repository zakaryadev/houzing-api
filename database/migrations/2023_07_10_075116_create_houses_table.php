<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('house_details_id')->constrained()->onDelete('cascade');
            $table->float('price');
            $table->float('sale_price');
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->string('adress');
            $table->string('city');
            $table->string('region');
            $table->string('country');
            $table->string('zip_code');
            $table->foreignId('categories_id')->constrained()->onDelete('cascade');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
