<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolGaleriaImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_galeria_images', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('path',255);
           // $table->unsignedBigInteger('file_id');
            ///$table->foreign('file_id')->references('id')->on('tbl_sinpol_convencoes');
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
        Schema::dropIfExists('tbl_sinpol_galeria_images');
    }
}
