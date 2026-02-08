<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ai_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Input Data
            $table->string('name');
            $table->string('gender'); // Laki-laki, Perempuan
            $table->integer('age');
            $table->integer('height');
            $table->integer('weight');
            $table->text('health_history')->nullable(); // JSON or comma separated
            $table->string('exercise_frequency');
            $table->string('gym_experience');
            $table->string('diet_pattern');
            $table->string('target');
            $table->text('complaint')->nullable();

            // Result Data
            $table->float('bmi_score');
            $table->string('bmi_status');
            $table->integer('bmr')->nullable();
            $table->integer('tdee')->nullable();
            $table->string('recommendation_package');
            $table->text('ai_diagnosis')->nullable();
            $table->json('recommendation_data')->nullable(); // Stores price, benefits, etc.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_analyses');
    }
};
