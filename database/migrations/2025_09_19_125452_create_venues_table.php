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
        Schema::create('venues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('city');
            $table->string('street');
            $table->string('place_type');
            $table->integer('parking_spot_count');
            $table->text('additional_info')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index('venues_ibfk_1');
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('editor_id')->nullable()->index('venues_ibfk_2');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
