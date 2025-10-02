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
        Schema::table('films', function (Blueprint $table) {
            $table->foreign(['user_id'], 'films_ibfk_1')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['editor_id'], 'films_ibfk_2')->references(['id'])->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('films', function (Blueprint $table) {
            $table->dropForeign('films_ibfk_1');
            $table->dropForeign('films_ibfk_2');
        });
    }
};
