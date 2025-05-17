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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('medicine_code');
            $table->string('ingredient')->nullable();
            $table->string('dosage_strength')->nullable();
            $table->string('unit');
            $table->string('packaging')->nullable();
            $table->string('base_unit')->default('viên');
            $table->integer('quantity_per_unit')->default(1);
            $table->integer('sale_price');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
