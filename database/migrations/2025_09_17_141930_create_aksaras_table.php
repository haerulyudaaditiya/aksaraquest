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
        Schema::create('aksaras', function (Blueprint $table) {
            $table->id();
            $table->string('character', 10);
            $table->string('latin');
            $table->string('audio_url')->nullable();
            $table->text('philosophy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aksaras');
    }
};
