<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeasurementsToBabiesTable extends Migration
{
    public function up()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->decimal('current_weight', 5, 2)->nullable()->after('birth_weight');
            $table->decimal('current_height', 5, 2)->nullable()->after('current_weight');
        });
    }

    public function down()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->dropColumn(['current_weight', 'current_height']);
        });
    }
}
