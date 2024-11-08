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
            $table->id()->autoIncrement();
            $table->timestamp('data');
            $table->string('titulo',200);
            $table->string('slug',255);
            $table->string('subtitulo',255);
            $table->longText('conteudo');
            $table->integer('imagem_id')->nullable(true);
            $table->boolean('status')->default(false);
            $table->boolean('destaque')->default(false);
            $table->integer('qtd_views')->nullable(false)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
