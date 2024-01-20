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
        Schema::table('tests', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['quiz_id']);

            $table->foreign('quiz_id')->references('id')
                ->on('quizzes')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            //
        });
    }
};
