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
        Schema::create('replacements', function (Blueprint $table) {
            $table->id();
            $table->string('art')->nullable();
            $table->text('desc')->nullable();
            $table->unsignedInteger('qnt')->nullable();
            $table->string('prz')->nullable();
            $table->string('sconto')->nullable();
            $table->string('tot')->nullable();
            $table->unsignedBigInteger('ticket_id');
            $table->timestamps();

            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replacements');
    }
};
