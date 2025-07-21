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
        Schema::create('clinic_records', function (Blueprint $table) {
            $table->id();
            $table->morphs('patientable'); // Polymorphic: patientable_id, patientable_type
            $table->date('visit_date')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->decimal('head_circumference', 5, 2)->nullable(); // For babies
            $table->decimal('temperature', 4, 1)->nullable(); // For babies
            $table->string('blood_pressure', 10)->nullable(); // For mothers
            $table->decimal('fundal_height', 5, 2)->nullable(); // For mothers
            $table->integer('fetal_heart_rate')->nullable(); // For mothers
            $table->string('urine_test')->nullable(); // For mothers
            $table->boolean('thriposha_given')->default(false);
            $table->string('thriposha_quantity')->nullable();
            $table->date('next_thriposha_date')->nullable();
            $table->json('vaccinations')->nullable(); // For babies, store as JSON
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinic_records');
    }
};
