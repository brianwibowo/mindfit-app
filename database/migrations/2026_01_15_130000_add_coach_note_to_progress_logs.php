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
            $table->text('coach_note')->nullable()->after('description');
            $table->foreignId('coach_id')->nullable()->after('coach_note')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_logs', function (Blueprint $table) {
            $table->dropForeign(['coach_id']);
            $table->dropColumn(['coach_note', 'coach_id']);
        });
    }
};
