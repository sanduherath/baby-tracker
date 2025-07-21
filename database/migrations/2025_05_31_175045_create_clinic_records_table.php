<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('patient_id');
            $table->string('patient_type'); // 'baby' or 'pregnant'
            $table->decimal('weight', 5, 2)->nullable(); // Weight in kg
            $table->decimal('height', 5, 2)->nullable(); // Height in cm
            $table->decimal('head_circumference', 5, 2)->nullable(); // Head circumference in cm (for babies, checkup)
            $table->string('nutrition')->nullable(); // Thriposha, vitamins, etc. (for checkup)
            $table->string('vaccination_name')->nullable(); // Vaccination given (for vaccination)
            $table->text('midwife_accommodations')->nullable(); // Midwife notes
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_records');
    }
};
