<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('progress_logs', function (Blueprint $table) {
            $table->date('date')->after('client_id')->default(now());
            $table->decimal('weight', 5, 2)->nullable()->after('type'); // kg
            $table->decimal('waist', 5, 2)->nullable()->after('weight'); // cm
            $table->string('photo')->nullable()->change(); // Make nullable just in case
        });
    }

    public function down(): void
    {
        Schema::table('progress_logs', function (Blueprint $table) {
            $table->dropColumn(['date', 'weight', 'waist']);
        });
    }
};
