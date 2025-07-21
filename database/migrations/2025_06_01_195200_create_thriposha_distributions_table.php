<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('thriposha_distributions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('type', ['baby', 'mother']);
            $table->unsignedInteger('quantity');
            $table->enum('transaction_type', ['addition', 'distribution'])->default('distribution');
            $table->string('recipient');
            $table->foreignId('recipient_id')->nullable()->constrained('patients')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
            $table->date('expected_date')->nullable();
            $table->unsignedInteger('baby_thriposha_quantity')->default(0);
            $table->unsignedInteger('mother_thriposha_quantity')->default(0);
            $table->timestamps();
        });

        $latestRecord = DB::table('thriposha_distributions')
            ->orderBy('id', 'desc')
            ->first();

        if ($latestRecord) {
            $babyStock = DB::table('thriposha_distributions')
                ->where('type', 'baby')
                ->where('transaction_type', 'addition')
                ->sum('quantity') -
                DB::table('thriposha_distributions')
                ->where('type', 'baby')
                ->where('transaction_type', 'distribution')
                ->sum('quantity');

            $motherStock = DB::table('thriposha_distributions')
                ->where('type', 'mother')
                ->where('transaction_type', 'addition')
                ->sum('quantity') -
                DB::table('thriposha_distributions')
                ->where('type', 'mother')
                ->where('transaction_type', 'distribution')
                ->sum('quantity');

            DB::table('thriposha_distributions')
                ->where('id', $latestRecord->id)
                ->update([
                    'baby_thriposha_quantity' => max(0, $babyStock),
                    'mother_thriposha_quantity' => max(0, $motherStock),
                ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('thriposha_distributions');
    }
};
