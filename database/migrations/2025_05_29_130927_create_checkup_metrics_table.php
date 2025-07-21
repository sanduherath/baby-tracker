<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckupMetricsTable extends Migration
{
    public function up()
    {
        Schema::create('checkup_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->decimal('weight', 5, 2)->nullable(); // in kg
            $table->decimal('length', 5, 2)->nullable(); // in cm
            $table->decimal('head_circumference', 5, 2)->nullable(); // in cm
            $table->decimal('temperature', 5, 2)->nullable(); // in °F
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkup_metrics');
    }
}
