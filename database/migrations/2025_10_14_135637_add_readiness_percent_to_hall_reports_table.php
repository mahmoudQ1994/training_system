<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('hall_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('created_by')->nullable()->after('hall_id');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            $table->decimal('readiness_percent', 5, 2)->nullable()->after('notes');


            // لو عندك جدول users (الافتراضي في Laravel)
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

        });
    }

    public function down()
    {
        Schema::table('hall_reports', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['created_by', 'updated_by']);
        });
    }

};
