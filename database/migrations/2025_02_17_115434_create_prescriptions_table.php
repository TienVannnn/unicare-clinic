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
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_certificate_id');
            $table->unsignedBigInteger('doctor_id');
            $table->text('note')->nullable();
            $table->bigInteger('total_payment');
            $table->integer('status');
            $table->foreign('medical_certificate_id')->references('id')->on('medical_certificates')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('admins')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
