<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolNoticiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_noticias', function (Blueprint $table) {
            $table->id();

            $table->timestamp('data');
            $table->string('titulo');
            $table->text('conteudo');
            $table->integer('imagem_id');
            $table->boolean('status');

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
        Schema::dropIfExists('tbl_sinpol_noticias');
    }
}
