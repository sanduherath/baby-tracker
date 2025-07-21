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
        Schema::create('mohs', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('registration_no')->unique();
            $table->string('nic')->unique();
            $table->date('date_of_birth');
            $table->string('contact');
            $table->string('moh_area');
            $table->string('hospital');
            $table->string('email')->unique();
            $table->integer('midwives_supervised');
            $table->integer('phm_areas_covered');
            $table->timestamps();
            $table->string('password')->nullable(); // Added password column

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mohs');
    }
};
