<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id')->unique();
            $table->string('nik')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender',['Male','Female','Other']);
            $table->string('tgl_lahir');
            $table->text('tmp_lahir');
            $table->string('agama');
            $table->string('gol_darah');
            $table->string('status_nikah');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('media_id')->nullable();
            $table->string('status_kerja');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->foreign('position_id')
                            ->references('id')
                            ->on('positions')
                            ->onDelete('cascade');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->foreign('schedule_id')
                            ->references('id')
                            ->on('schedules')
                            ->onDelete('cascade');
            $table->unsignedBigInteger('id_rekening')->unique();
            $table->foreign('id_rekening')
                            ->references('id_rekening')
                            ->on('rekenings')
                            ->onDelete('cascade');
            $table->unsignedBigInteger('pajak_id')->nullable();
            $table->foreign('pajak_id')
                            ->references('pajak_id')
                            ->on('pajaks')
                            ->onDelete('cascade');
            $table->unsignedBigInteger('tunjangan_id')->nullable();
            $table->foreign('tunjangan_id')
                            ->references('tunjangan_id')
                            ->on('tunjangans')
                            ->onDelete('cascade');
            $table->unsignedBigInteger('deduction_id')->nullable();
            $table->foreign('deduction_id')
                            ->references('deduction_id')
                            ->on('deductions')
                            ->onDelete('cascade');
            $table->decimal('salary',11,2)->comment("It's just for information purpose.");
            $table->boolean('is_active');
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
        Schema::dropIfExists('employees');
    }
}
