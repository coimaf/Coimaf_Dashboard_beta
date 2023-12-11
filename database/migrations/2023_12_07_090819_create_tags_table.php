<?php

use App\Models\Tag;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();  
            $table->string('name');
            $table->timestamps();
        });
        
            $tags = ['Importante','Assicurazione','Enel','Altro','Revisione','Assegno'];
                
                foreach($tags as $tag) {
                    Tag::create(['name' => $tag]);
                }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
