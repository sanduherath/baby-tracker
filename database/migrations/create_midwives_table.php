<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('midwives', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('nic')->unique();
            $table->string('contact_number');
            $table->string('email')->nullable()->unique(); // Added unique constraint
            $table->string('phm_area');
            $table->string('registration_number')->unique();
            $table->date('start_date');
            $table->string('training_level');
            $table->text('address');
            $table->text('notes')->nullable();
            $table->boolean('active_status')->default(true);
            $table->string('password')->nullable(); // Added password column
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('midwives');
    }
};
