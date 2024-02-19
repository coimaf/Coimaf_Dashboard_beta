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
        Schema::create('r4_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('r4_id');
            $table->foreign('r4_id')->references('id')->on('r4_s')->onDelete('cascade');
            $table->string('name');
            $table->string('file')->nullable();
            $table->date('date_start')->nullable();
            $table->date('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r4_documents');
    }
};
