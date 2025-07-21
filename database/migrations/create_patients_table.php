<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'baby' or 'pregnant'
            $table->string('district');
            $table->string('grama_niladhari_division');
            $table->string('moh_area');
            $table->text('address');
            $table->morphs('patientable'); // Polymorphic relationship
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
