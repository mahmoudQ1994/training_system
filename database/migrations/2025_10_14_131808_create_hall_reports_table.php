<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hall_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_id')->constrained('training_halls')->onDelete('cascade');
            $table->date('inspection_date');
            $table->string('inspected_by')->nullable();

            $table->integer('chairs_count')->nullable();
            $table->boolean('lecturer_desk')->default(false);
            $table->boolean('display_screen')->default(false);
            $table->boolean('computer_available')->default(false);
            $table->boolean('cables_available')->default(false);
            $table->boolean('paper_board')->default(false);
            $table->boolean('white_board')->default(false);
            $table->boolean('air_conditioning')->default(false);
            $table->integer('air_conditioning_count')->nullable();
            $table->boolean('internet_available')->default(false);
            $table->boolean('sound_system')->default(false);
            $table->boolean('lighting_good')->default(false);
            $table->boolean('ventilation_good')->default(false);
            $table->boolean('waiting_area')->default(false);
            $table->boolean('buffet_available')->default(false);
            $table->boolean('toilets_available')->default(false);
            $table->boolean('fire_extinguishers')->default(false);
            $table->boolean('emergency_exit')->default(false);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hall_reports');
    }
};
