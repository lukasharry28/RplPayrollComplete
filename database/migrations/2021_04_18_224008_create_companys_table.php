<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companys', function (Blueprint $table) {
            $table->bigIncrements('company_id');
            $table->string('company_name');
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->unsignedBigInteger('id_rekening') -> nullable();
            $table->foreign('id_rekening')
                            ->references('id_rekening')
                            ->on('rekenings')
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
        Schema::dropIfExists('companys');
    }
}
