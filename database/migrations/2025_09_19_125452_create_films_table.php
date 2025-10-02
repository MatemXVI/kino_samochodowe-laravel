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
        Schema::create('films', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('director')->nullable();
            $table->string('cast')->nullable();
            $table->string('screenplay')->nullable();
            $table->string('genre')->nullable();
            $table->integer('duration')->nullable();
            $table->string('country')->nullable();
            $table->integer('production_year')->nullable();
            $table->text('description')->nullable();
            $table->string('poster_filename')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('films_ibfk_1');
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable()->index('films_ibfk_2');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
