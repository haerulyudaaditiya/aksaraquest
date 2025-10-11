<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->foreignId('aksara_id')->nullable()->constrained()->onDelete('set null')->after('lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['aksara_id']);
            $table->dropColumn('aksara_id');
        });
    }
};
