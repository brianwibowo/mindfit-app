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
        Schema::table('coach_client', function (Blueprint $table) {
            $table->string('type')->default('fitness')->after('client_id'); // fitness, nutrition
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->text('image')->nullable()->change(); // Change string to text/longtext for JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coach_client', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
        });
    }
};
