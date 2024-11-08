<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_videos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('link',155)->nullable(false)->comment("link do vídeo no youtube por exemplo, obrigatório");
            $table->string('titulo',150)->nullable(false)->comment('titulo do vídeo');
            $table->string('slug',155)->nullable(false)->comment("slug do vídeo no youtube por exemplo, obrigatório");
            $table->string('subtitulo',255)->nullable(true);
            $table->boolean('status')->default(false)->comment("ativa ou desativa o video para ser exibido no site");

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
        Schema::dropIfExists('tbl_sinpol_videos');
    }
}
