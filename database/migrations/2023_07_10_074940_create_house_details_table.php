<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('house_details', function (Blueprint $table) {
            $table->id();
            $table->integer('num_beds');
            $table->integer('num_rooms');
            $table->integer('num_bath');
            $table->integer('num_garage');
            $table->float('area');
            $table->float('year_built');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('house_details');
    }
};
