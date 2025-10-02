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
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign(['screening_id'], 'tickets_ibfk_1')->references(['id'])->on('screenings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['user_id'], 'tickets_ibfk_2')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_ibfk_1');
            $table->dropForeign('tickets_ibfk_2');
        });
    }
};
