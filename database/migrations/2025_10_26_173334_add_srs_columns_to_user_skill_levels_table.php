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
        Schema::table('user_skill_levels', function (Blueprint $table) {
            $table->timestamp('last_practiced_at')->nullable()->after('correct_streak');
            $table->timestamp('next_review_at')->nullable()->after('last_practiced_at');
            $table->index('next_review_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_skill_levels', function (Blueprint $table) {
            $table->dropIndex(['next_review_at']);
            $table->dropColumn(['last_practiced_at', 'next_review_at']);
        });
    }
};