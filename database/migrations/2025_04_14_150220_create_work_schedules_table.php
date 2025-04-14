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
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('admins')->onDelete('cascade');
            $table->time('morning_start')->default('08:00');
            $table->time('morning_end')->default('11:30');
            $table->time('afternoon_start')->default('13:30');
            $table->time('afternoon_end')->default('17:00');
            $table->integer('slot_duration')->default(15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_schedules');
    }
};
