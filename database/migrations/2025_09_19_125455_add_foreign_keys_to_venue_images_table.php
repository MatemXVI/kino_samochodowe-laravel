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
        Schema::table('venue_images', function (Blueprint $table) {
            $table->foreign(['venue_id'], 'venue_images_ibfk_1')->references(['id'])->on('venues')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venue_images', function (Blueprint $table) {
            $table->dropForeign('venue_images_ibfk_1');
        });
    }
};
