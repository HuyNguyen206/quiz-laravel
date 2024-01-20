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
        Schema::table('test_answer', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['test_id']);
            $table->dropForeign(['question_id']);
            $table->dropForeign(['option_id']);

            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
            $table->foreign('test_id')->references('id')
                ->on('tests')->cascadeOnDelete();
            $table->foreign('question_id')->references('id')
                ->on('questions')->cascadeOnDelete();
            $table->foreign('option_id')->references('id')
                ->on('question_options')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('test_answer', function (Blueprint $table) {
            //
        });
    }
};
