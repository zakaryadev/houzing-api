<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('house_components', function (Blueprint $table) {
            $table->id();
            $table->string('additional')->nullable();
            $table->boolean('air_condition')->default(false);
            $table->boolean('courtyard')->default(false);
            $table->boolean('furniture')->default(false);
            $table->boolean('gas_stove')->default(false);
            $table->boolean('internet')->default(false);
            $table->boolean('tv')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('house_components');
    }
};
