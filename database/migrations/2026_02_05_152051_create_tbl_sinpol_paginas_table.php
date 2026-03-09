<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolPaginasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tbl_sinpol_paginas')) {
            Schema::create('tbl_sinpol_paginas', function (Blueprint $table) {
                $table->id()->autoIncrement()->comment("id da pagina");
                $table->string('titulo', 150)->comment("Titulo/Identificador da página (ex: História)");
                $table->string('slug', 155)->unique()->comment("URL amigável (ex: historia)");
                $table->longText('conteudo')->comment("Conteúdo HTML da página");
                $table->boolean('status')->default(true)->comment("1=Ativo, 0=Inativo");
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_sinpol_paginas');
    }
}
