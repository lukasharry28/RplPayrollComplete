<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekenings', function (Blueprint $table) {
            $table->bigIncrements('id_rekening');
            $table->string('no_rekening');
            $table->string('rekening_name');
            $table->string('type_rekening');
            $table->decimal('saldo', 16, 2);
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->foreign('bank_id')
                            ->references('bank_id')
                            ->on('banks')
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
        Schema::dropIfExists('rekenings');
    }
}
