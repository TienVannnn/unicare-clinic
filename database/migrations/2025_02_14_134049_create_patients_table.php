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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_code')->unique()->nullable();
            $table->string('name');
            $table->date('dob');
            $table->integer('gender');
            $table->string('phone', 11);
            $table->mediumText('address');
            $table->string('cccd', 13)->nullable();
            $table->string('bhyt_number', 20)->nullable();
            $table->string('hospital_registered', 100)->nullable();
            $table->date('bhyt_expired_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
