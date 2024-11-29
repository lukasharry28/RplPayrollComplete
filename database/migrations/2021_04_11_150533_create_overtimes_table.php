<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->bigIncrements('overtime_id');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->decimal('rate_amount_hourse',11,2);
            $table->decimal('work_hours', 11, 2);
            $table->date('date');
            $table->decimal('total_amount',11,2);
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')
                            ->references('id')
                            ->on('employees')
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
        Schema::dropIfExists('overtimes');
    }
}
