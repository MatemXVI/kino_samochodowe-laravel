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
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('created_at')->nullable();
            $table->integer('parking_spot_number')->nullable();
            $table->unsignedBigInteger('screening_id')->index('tickets_ibfk_1');
            $table->unsignedBigInteger('user_id')->nullable()->index('tickets_ibfk_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
