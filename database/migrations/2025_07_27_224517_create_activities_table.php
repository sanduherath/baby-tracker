<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('baby_id');
            $table->string('description');
            $table->text('details')->nullable();
            $table->dateTime('activity_date');
            $table->timestamps();
            $table->foreign('baby_id')->references('id')->on('babies')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
