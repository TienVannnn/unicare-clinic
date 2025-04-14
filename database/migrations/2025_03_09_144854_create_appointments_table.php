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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 50);
            $table->string('phone', 11);
            $table->date('dob');
            $table->tinyInteger('gender');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('doctor_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->date('appointment_date');
            $table->time('start_time');
            $table->text('note');
            $table->boolean('is_viewed');
            $table->tinyInteger('status');
            $table->string('cancel_token')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
