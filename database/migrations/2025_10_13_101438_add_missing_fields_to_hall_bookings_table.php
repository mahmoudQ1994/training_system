<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hall_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('hall_bookings', 'end_date')) {
                $table->date('end_date')->nullable()->after('booking_date');
            }

            if (!Schema::hasColumn('hall_bookings', 'requesting_department')) {
                $table->string('requesting_department')->nullable()->after('purpose');
            }

            if (!Schema::hasColumn('hall_bookings', 'payment_status')) {
                $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid')->after('requesting_department');
            }

            if (!Schema::hasColumn('hall_bookings', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('payment_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('hall_bookings', function (Blueprint $table) {
            $table->dropColumn(['end_date', 'requesting_department', 'payment_status', 'status']);
        });
    }
};
