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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('avatar')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 11)->nullable();
            $table->string('address')->nullable();
            $table->integer('gender')->nullable();
            $table->mediumText('experience');
            $table->foreignId('clinic_id')->constrained('clinics')->onDelete('restrict');
            $table->string('token_reset_password')->nullable();
            $table->timestamp('token_duration')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
