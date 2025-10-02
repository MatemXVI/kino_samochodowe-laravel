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
        Schema::create('film_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image_filename');
            $table->unsignedBigInteger('film_id')->index('film_images_ibfk_1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film_images');
    }
};
