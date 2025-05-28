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
        Schema::create('medical_certificate_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_certificate_id')->constrained('medical_certificates')->onDelete('cascade');
            $table->unsignedBigInteger('medical_service_id')->nullable();
            $table->foreign('medical_service_id')->references('id')->on('medical_services')->onDelete('set null');
            $table->unsignedBigInteger('clinic_id')->nullable();
            $table->foreign('clinic_id')->references('id')->on('clinics')->onDelete('set null');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('admins')->onDelete('set null');
            $table->timestamp('medical_time')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_certificate_service');
    }
};
