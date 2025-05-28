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
        Schema::create('medical_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('medical_certificate_code', 15)->nullable();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->tinyInteger('medical_status');
            $table->tinyInteger('payment_status');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->unsignedBigInteger('medical_service_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('set null');
            $table->text('symptom')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('conclude')->nullable();
            $table->text('result_file')->nullable();
            $table->date('discharge_date')->nullable();
            $table->timestamp('medical_time')->nullable();
            $table->date('re_examination_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_certificates');
    }
};
