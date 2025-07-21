<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('babies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->date('birth_date');
            $table->decimal('birth_weight', 5, 2);
            $table->string('birth_hospital')->nullable();
            $table->string('delivery_type')->nullable();
            $table->integer('gestational_age')->nullable();
            $table->string('mother_name');
            $table->string('mother_nic');
            $table->string('mother_contact');
            $table->string('mother_email'); // Added parent email field
            $table->string('father_name')->nullable();
            $table->string('father_contact')->nullable();
            $table->text('address')->nullable(); // Added address field
            $table->text('birth_complications')->nullable();
            $table->text('congenital_conditions')->nullable();
            $table->boolean('bcg_vaccine')->default(false);
            $table->boolean('opv0_vaccine')->default(false);
            $table->boolean('hepb_vaccine')->default(false);
            $table->text('additional_notes')->nullable();
            $table->string('password')->default('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); // Default hashed 'user123'
            $table->rememberToken(); // For authentication
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('babies');
    }
};
