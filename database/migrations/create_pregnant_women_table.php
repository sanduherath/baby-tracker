<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pregnant_women', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nic');
            $table->date('dob');
            $table->string('contact');
            $table->string('email')->nullable();
            $table->string('occupation')->nullable();
            $table->string('husband_name')->nullable();
            $table->string('husband_contact')->nullable();
            $table->text('address')->nullable(); // Added address field
            $table->string('grama_niladhari_division')->nullable(); // Added GN division
            $table->string('district')->nullable(); // Added district
            $table->string('moh_area')->nullable(); // Added MOH area
            $table->date('lmp_date');
            $table->date('edd_date');
            $table->integer('gravida');
            $table->integer('para');
            $table->integer('abortions')->nullable();
            $table->integer('living_children')->nullable();
            $table->text('previous_complications')->nullable();
            $table->text('current_complications')->nullable();
            $table->boolean('diabetes')->default(false);
            $table->boolean('hypertension')->default(false);
            $table->boolean('asthma')->default(false);
            $table->boolean('heart_disease')->default(false);
            $table->boolean('thyroid')->default(false);
            $table->boolean('other_condition')->default(false);
            $table->text('other_medical_info')->nullable();
            $table->string('password')->default('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); // Default hashed 'user123'
            $table->rememberToken(); // For 'remember me' functionality
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pregnant_women');
    }
};
