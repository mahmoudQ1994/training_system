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
    Schema::table('hall_bookings', function (Blueprint $table) {
        $table->string('requesting_department')->nullable()->after('purpose');
        $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid')->after('requesting_department');
    });
}

public function down(): void
{
    Schema::table('hall_bookings', function (Blueprint $table) {
        $table->dropColumn(['requesting_department', 'payment_status']);
    });
}

};
