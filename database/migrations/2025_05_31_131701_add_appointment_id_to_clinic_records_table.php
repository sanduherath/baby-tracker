<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppointmentIdToClinicRecordsTable extends Migration
{
    public function up()
    {
        Schema::table('clinic_records', function (Blueprint $table) {
            $table->unsignedBigInteger('appointment_id')->nullable()->after('patientable_type');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('clinic_records', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropColumn('appointment_id');
        });
    }
}
