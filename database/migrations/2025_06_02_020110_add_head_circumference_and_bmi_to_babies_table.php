<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeadCircumferenceAndBmiToBabiesTable extends Migration
{
    public function up()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->decimal('head_circumference', 5, 2)->nullable()->after('current_height');
            $table->decimal('bmi', 5, 2)->nullable()->after('head_circumference');
        });
    }

    public function down()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->dropColumn(['head_circumference', 'bmi']);
        });
    }
}
