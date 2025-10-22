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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('program_type', ['course','conference','day'])->default('course'); // دورة/مؤتمر/يوم علمي
            $table->string('organizer')->nullable(); // الجهة المنفذة
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('instructor')->nullable();
            $table->enum('target_group', [
                    'طبيب بشري',
                    'طبيب أسنان',
                    'صيدلي',
                    'علاج طبيعي',
                    'تمريض',
                    'أخصائي علوم صحية',
                    'فني صحي',
                    'إداري',
                    'أخرى'
            ])->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('draft'); // draft | published | cancelled
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
