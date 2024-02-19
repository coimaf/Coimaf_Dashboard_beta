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
        Schema::create('r4_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->unsignedBigInteger('type_r4_id')->nullable();
            $table->string('name')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('control_frequency')->nullable();
            $table->text('description')->nullable();
            $table->date('buy_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('type_r4_id')->references('id')->on('type_r4_s')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r4_s');
    }
};