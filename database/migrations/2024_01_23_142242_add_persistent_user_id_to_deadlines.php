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
        Schema::table('deadlines', function (Blueprint $table) {
            $table->unsignedBigInteger('persistent_user_id')->nullable();

            $table->foreign('persistent_user_id')->references('id')->on('persistent_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deadlines', function (Blueprint $table) {
            $table->dropForeign(['persistent_user_id']);
            $table->dropColumn('persistent_user_id');
        });
    }
};
