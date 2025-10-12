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
        Schema::create('story_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('story_id')->constrained()->cascadeOnDelete();
            $table->text('aksara_word'); // Kata dalam Aksara Sunda, misal: ᮞᮞᮊᮜ
            $table->string('latin_word'); // Kata dalam Latin, misal: sasakala
            $table->integer('paragraph_number')->default(1);
            $table->integer('order_in_paragraph')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('story_contents');
    }
};
