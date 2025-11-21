<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->string('period_month');
            $table->date('payment_date');
            $table->decimal('base_salary', 12, 2);
            $table->decimal('allowance', 12, 2);
            $table->decimal('cut', 12, 2);
            $table->decimal('absence_deduction', 12, 2);
            $table->integer('total_absence');
            $table->integer('total_late');
            $table->integer('working_days');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
