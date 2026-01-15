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
        Schema::table('progress_logs', function (Blueprint $table) {
            // Change enum to string to allow 'body_check' and dynamic types
            $table->string('type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_logs', function (Blueprint $table) {
            // Revert back strictly if needed, but risky if data exists.
            // For safety we might just leave it as string or try to enum
            // $table->enum('type', ['workout', 'nutrition'])->change(); 
        });
    }
};
