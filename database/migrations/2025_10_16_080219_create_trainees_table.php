<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            
            // البرنامج التابع له المتدرب
            $table->foreignId('program_id')
                ->constrained('programs')
                ->onDelete('cascade');

            // بيانات المتدرب
            $table->string('name_ar'); // الاسم بالعربية
            $table->string('name_en')->nullable(); // الاسم بالإنجليزية
            $table->string('national_id', 14); // الرقم القومي
            $table->string('email')->nullable();
            $table->string('specialization')->nullable(); // التخصص
            $table->string('job_title')->nullable(); // المسمى الوظيفي
            $table->string('organization')->nullable(); // جهة العمل

            $table->timestamps();

            // 🔒 منع تكرار نفس المتدرب في نفس البرنامج بناءً على الرقم القومي
            $table->unique(['program_id', 'national_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
