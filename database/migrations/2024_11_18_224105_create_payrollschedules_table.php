<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrollschedules', function (Blueprint $table) {
            $table->bigIncrements('payschedule_id');
            $table->unsignedBigInteger('company_id');
            $table->date('payroll_date');
            $table->enum('payroll_status', ['Confirmed', 'Failed', 'Progress']);

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
        Schema::dropIfExists('payrollschedules');
    }
}
