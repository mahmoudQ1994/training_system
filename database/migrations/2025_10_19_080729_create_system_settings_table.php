<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();

            $table->string('system_name')->nullable();           // اسم النظام
            $table->string('directorate_name')->nullable();      // اسم المديرية
            $table->string('department_name')->nullable();       // اسم الإدارة
            $table->string('primary_color')->nullable();         // اللون الأساسي
            $table->string('secondary_color')->nullable();       // اللون الثانوي
            $table->string('default_language')->default('ar');  // اللغة الافتراضية
            $table->string('default_email')->nullable();         // البريد الإلكتروني الافتراضي
            $table->boolean('notifications_enabled')->default(true); // الإشعارات مفعلة

            $table->string('logo_path')->nullable();            // شعار النظام

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};
