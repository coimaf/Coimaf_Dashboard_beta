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
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('closed')->nullable();
            $table->text('notes')->nullable();
            $table->string('descrizione');
            $table->string('cd_cf');
            $table->date('intervention_date')->nullable();
            $table->boolean('pagato')->default(false);
            $table->bigInteger('rapportino')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('machine_sold_id')->nullable();
            $table->foreign('machine_sold_id')->references('id')->on('machines_solds')->onDelete('set null');

            $table->unsignedBigInteger('machine_model_id')->nullable();
            $table->foreign('machine_model_id')->references('id')->on('machines_solds')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
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
