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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'coach', 'client'])->default('client')->after('email');
            
            // Tambahkan ini untuk foto profil
            $table->string('avatar')->nullable()->after('role'); 
            
            $table->boolean('is_premium')->default(false)->after('avatar');
            $table->timestamp('premium_until')->nullable()->after('is_premium');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'is_premium', 'premium_until']);
        });
    }
};
