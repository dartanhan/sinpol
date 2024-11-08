<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolConveniosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_convenios', function (Blueprint $table) {
            $table->id()->autoIncrement()->comment("identificação da tabela");
            $table->longText('conteudo')->nullable(false)->comment("conteudo do tiny mce");
            $table->string('titulo',150)->nullable(false)->comment('titulo do convenio');
            $table->string('slug',155)->nullable(false)->comment("slug identificação pagina, obrigatório");
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
        Schema::dropIfExists('tbl_sinpol_convenios');
    }
}
