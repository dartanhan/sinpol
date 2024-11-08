<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolConvencoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_convencoes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("titulo_cct",500);
            $table->string("data_cct",10);
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('tbl_sinpol_galeria_images');
            $table->boolean("status")->default(false);
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
        Schema::dropIfExists('tbl_sinpol_convencoes');
    }
}
