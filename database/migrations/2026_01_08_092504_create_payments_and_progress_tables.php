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
        // Tabel Pembayaran
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('proof_file');
            $table->integer('duration_months');
            $table->enum('status', ['pending', 'approved', 'revision', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable(); // Alasan revisi
            $table->timestamps();
        });
    }
};
