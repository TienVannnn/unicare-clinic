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
        Schema::table('prescription_medicine', function (Blueprint $table) {
            Schema::table('prescription_medicine', function (Blueprint $table) {
                $table->unsignedBigInteger('medicine_batch_id')->nullable()->after('medicine_id');
                $table->foreign('medicine_batch_id')->references('id')->on('medicine_batches')->onDelete('set null');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prescription_medicine', function (Blueprint $table) {
            $table->dropForeign(['medicine_batch_id']);
            $table->dropColumn('medicine_batch_id');
        });
    }
};
