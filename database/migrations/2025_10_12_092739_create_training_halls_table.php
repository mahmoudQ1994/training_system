<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_halls', function (Blueprint $table) {
            $table->id();
            $table->string('hall_name', 150);
            $table->string('hall_code', 50)->nullable()->unique();
            $table->string('building_name', 100)->nullable();
            $table->string('floor_number', 50)->nullable();
            $table->integer('capacity')->nullable();
            $table->json('facilities')->nullable(); // سيتم تخزين التجهيزات كـ JSON
            $table->enum('status', ['متاحة','محجوزة','صيانة' ,'مغلقة '])->default('متاحة');
            $table->string('image')->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_halls');
    }
};
