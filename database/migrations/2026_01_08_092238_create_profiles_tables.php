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
        // Tabel untuk data tambahan Coach
        Schema::create('coach_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialization')->nullable(); // Misal: Fat Loss, Muscle Building
            $table->text('bio')->nullable();
            $table->timestamps();
        });

        // Tabel untuk data tambahan Klien
        Schema::create('client_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('weight')->nullable(); // dalam kg
            $table->integer('height')->nullable(); // dalam cm
            $table->timestamps();
        });
    }
};
