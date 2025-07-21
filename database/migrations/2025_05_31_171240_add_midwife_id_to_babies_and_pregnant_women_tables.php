<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMidwifeIdToBabiesAndPregnantWomenTables extends Migration
{
    public function up()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->unsignedBigInteger('midwife_id')->nullable()->after('id');
            $table->foreign('midwife_id')->references('id')->on('midwives')->onDelete('set null');
        });

        Schema::table('pregnant_women', function (Blueprint $table) {
            $table->unsignedBigInteger('midwife_id')->nullable()->after('id');
            $table->foreign('midwife_id')->references('id')->on('midwives')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->dropForeign(['midwife_id']);
            $table->dropColumn('midwife_id');
        });

        Schema::table('pregnant_women', function (Blueprint $table) {
            $table->dropForeign(['midwife_id']);
            $table->dropColumn('midwife_id');
        });
    }
}
