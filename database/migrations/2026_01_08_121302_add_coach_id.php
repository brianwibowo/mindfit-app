<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_profiles', function (Blueprint $table) {
            // Kita hubungkan ke ID di tabel coach_profiles
            // nullable() karena saat awal daftar, klien mungkin belum punya coach
            $table->foreignId('coach_id')
                  ->after('user_id')
                  ->nullable()
                  ->constrained('coach_profiles')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('client_profiles', function (Blueprint $table) {
            $table->dropForeign(['coach_id']);
            $table->dropColumn('coach_id');
        });
    }
};