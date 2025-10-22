<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'national_id')) {
                $table->string('national_id', 20)->nullable()->after('id');
            }

            if (!Schema::hasColumn('users', 'job_title')) {
                $table->string('job_title')->nullable()->after('name');
            }

            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('job_title');
            }

            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['user', 'admin', 'super_admin'])->default('user')->after('address');
            }

            if (!Schema::hasColumn('users', 'photo')) {
                $table->string('photo')->nullable()->after('role');
            }

            // ✅ عمود الحالة (نشط / غير نشط)
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active')->after('photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'national_id')) $table->dropColumn('national_id');
            if (Schema::hasColumn('users', 'job_title')) $table->dropColumn('job_title');
            if (Schema::hasColumn('users', 'phone')) $table->dropColumn('phone');
            if (Schema::hasColumn('users', 'address')) $table->dropColumn('address');
            if (Schema::hasColumn('users', 'role')) $table->dropColumn('role');
            if (Schema::hasColumn('users', 'photo')) $table->dropColumn('photo');
            if (Schema::hasColumn('users', 'status')) $table->dropColumn('status');
        });
    }
};
