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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('thumbnail');
            $table->longText('content');
            $table->tinyInteger('status');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('poster_id')->nullable();
            $table->foreign('category_id')->references('id')->on('news_categories')->onDelete('set null');
            $table->foreign('poster_id')->references('id')->on('admins')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
