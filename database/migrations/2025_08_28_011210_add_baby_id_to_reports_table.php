<?php

     use Illuminate\Database\Migrations\Migration;
     use Illuminate\Database\Schema\Blueprint;
     use Illuminate\Support\Facades\Schema;

     return new class extends Migration
     {
         public function up()
         {
             Schema::table('reports', function (Blueprint $table) {
                 $table->foreignId('baby_id')->constrained('babies')->onDelete('cascade');
             });
         }

         public function down()
         {
             Schema::table('reports', function (Blueprint $table) {
                 $table->dropForeign(['baby_id']);
                 $table->dropColumn('baby_id');
             });
         }
     };
