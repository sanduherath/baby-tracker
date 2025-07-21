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
    Schema::table('mohs', function (Blueprint $table) {
        $table->string('phm_areas_covered')->change();
    });
}

public function down()
{
    Schema::table('mohs', function (Blueprint $table) {
        $table->integer('phm_areas_covered')->change();
    });
}

};
use App\Models\Moh;
use App\Models\User;
use Illuminate\Support\Facades\Hash;User::create([
    'name' => $moh->full_name,
    'email' => $moh->email,
    'password' => $moh->password,
    'role' => 'moh',
]);
