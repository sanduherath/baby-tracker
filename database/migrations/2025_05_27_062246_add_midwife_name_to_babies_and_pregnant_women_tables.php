<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->string('midwife_name')->nullable()->after('additional_notes');
        });

        Schema::table('pregnant_women', function (Blueprint $table) {
            $table->string('midwife_name')->nullable()->after('other_medical_info');
        });
    }

    public function down()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->dropColumn('midwife_name');
        });

        Schema::table('pregnant_women', function (Blueprint $table) {
            $table->dropColumn('midwife_name');
        });
    }
};
