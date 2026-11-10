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
        Schema::create('partner_applications', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('organization')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('city_country')->nullable();
            $table->string('tier')->nullable();
            $table->text('business_description')->nullable();
            $table->enum('status', ['new', 'reviewed', 'contacted', 'rejected'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_applications');
    }
};
