<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThriposhaOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('thriposha_orders', function (Blueprint $table) {
            $table->id();
            $table->date('order_date');
            $table->string('type')->index(); // 'baby' or 'mother'
            $table->integer('quantity');
            $table->string('urgency'); // 'normal', 'urgent', 'emergency'
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'processing', 'delivered'
            $table->date('expected_delivery_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('thriposha_orders');
    }
}
