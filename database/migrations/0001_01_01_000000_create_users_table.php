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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('parent'); // parent, baby, pregnant, midwife, moh
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('expected_due_date')->nullable();
            $table->string('license_number')->nullable(); // For midwife/MOH
            $table->string('health_facility')->nullable(); // For healthcare professionals
            $table->text('address')->nullable();

            // Polymorphic relationship fields
            $table->unsignedBigInteger('patientable_id')->nullable();
            $table->string('patientable_type')->nullable();

            // Mother-baby relationship (for baby records)
            $table->unsignedBigInteger('mother_id')->nullable();

            $table->rememberToken();
            $table->timestamps();

            // Foreign key for mother-baby relationship
            $table->foreign('mother_id')->references('id')->on('users')->onDelete('set null');
        });

        // Pivot table for midwife-pregnant woman assignments
        Schema::create('midwife_pregnancies', function (Blueprint $table) {
            $table->foreignId('midwife_id')->constrained('users');
            $table->foreignId('pregnant_id')->constrained('users');
            $table->date('assigned_date')->useCurrent();
            $table->primary(['midwife_id', 'pregnant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('midwife_pregnancies');
        Schema::dropIfExists('users');
    }
};
