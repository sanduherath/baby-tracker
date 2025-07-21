<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('patient_type'); // 'baby' or 'pregnant'
            $table->unsignedBigInteger('patient_id'); // ID of Baby or PregnantWoman
            $table->unsignedBigInteger('midwife_id'); // ID of the midwife
            $table->date('date'); // Appointment date
            $table->time('time'); // Appointment time
            $table->string('type'); // 'vaccination', 'checkup', 'prenatal', 'other'
            $table->string('vaccination_type')->nullable(); // For vaccination appointments
            $table->text('notes')->nullable();
            $table->string('status')->default('scheduled'); // 'scheduled', 'completed', 'canceled'
            $table->timestamps();

            // Foreign keys (assuming Baby and PregnantWoman have their own tables)
            $table->foreign('midwife_id')->references('id')->on('midwives')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
