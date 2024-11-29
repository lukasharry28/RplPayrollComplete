<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('company_id');
            $table->date('date');
            $table->enum('payroll_status', ['Pending', 'Success', 'Failed'])->default('Pending');
            $table->decimal('deduction', 15, 2) -> nullable() -> default(0);
            $table->decimal('pajak', 15, 2) -> nullable() -> default(0);
            $table->decimal('tunjangan', 15, 2) -> nullable() -> default(0);
            $table->decimal('total_amount', 15, 2) -> nullable() -> default(0);
            $table->unsignedBigInteger('payschedule_id');
            $table->foreign('payschedule_id')
                            ->references('payschedule_id')
                            ->on('payrollschedules')
                            ->onDelete('cascade');
            $table->foreign('employee_id')
                            ->references('id')
                            ->on('employees')
                            ->onDelete('cascade');
            $table->foreign('company_id')
                            ->references('company_id')
                            ->on('companys')
                            ->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
    
}
