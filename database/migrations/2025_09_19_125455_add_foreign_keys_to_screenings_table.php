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
        Schema::table('screenings', function (Blueprint $table) {
            $table->foreign(['film_id'], 'screenings_ibfk_1')->references(['id'])->on('films')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['venue_id'], 'screenings_ibfk_2')->references(['id'])->on('venues')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['user_id'], 'screenings_ibfk_3')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['editor_id'], 'screenings_ibfk_4')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->dropForeign('screenings_ibfk_1');
            $table->dropForeign('screenings_ibfk_2');
            $table->dropForeign('screenings_ibfk_3');
            $table->dropForeign('screenings_ibfk_4');
        });
    }
};
