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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->integer('price')->nullable(false);
            $table->text('description')->nullable(false);
            $table->string('type')->nullable(false);
            $table->string('location')->nullable(false);
            $table->integer('number_of_rooms')->nullable(false);
            $table->integer('number_of_bathrooms')->nullable(false);
            $table->integer('area')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
