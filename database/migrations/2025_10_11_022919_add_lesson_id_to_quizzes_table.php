<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::table('quizzes', function (Blueprint $table) {
            // Kolom ini bisa null karena tidak semua kuis adalah kuis pelajaran (ada kuis Arena biasa)
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['lesson_id']);
            $table->dropColumn('lesson_id');
        });
    }
};
