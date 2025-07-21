<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::create('vaccinations', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('baby_id');
        $table->string('vaccine_name');
        $table->string('dose')->default('1st dose');
        $table->date('date_administered')->nullable(); // only when actually given
        $table->string('recommended_age')->nullable(); // e.g., "at birth", "2 months"
        $table->string('status'); // completed, missed, pending
        $table->string('administered_by')->nullable(); // doctor's or nurse's name
        $table->string('clinic_or_hospital')->nullable(); // place of vaccination
        $table->timestamps();

        $table->foreign('baby_id')->references('id')->on('babies')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vaccinations');
    }
};
