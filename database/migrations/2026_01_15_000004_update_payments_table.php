<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'package_id')) {
                $table->foreignId('package_id')->nullable()->after('user_id')->constrained('packages')->nullOnDelete();
            }
            if (!Schema::hasColumn('payments', 'package_data')) {
                $table->json('package_data')->nullable()->after('package_id');
            }
            if (!Schema::hasColumn('payments', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('status');
            }
            if (!Schema::hasColumn('payments', 'subscription_start')) {
                $table->date('subscription_start')->nullable()->after('admin_note');
            }
            if (!Schema::hasColumn('payments', 'subscription_end')) {
                $table->date('subscription_end')->nullable()->after('subscription_start');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Drop logic if needed, but for dev this is fine
        });
    }
};
