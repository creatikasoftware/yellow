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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->json('highlights')->nullable();
            $table->date('starts_at');
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('format')->nullable();
            $table->string('expected_attendees')->nullable();
            $table->string('image')->nullable();
            $table->string('brochure_path')->nullable();
            $table->boolean('registration_open')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
