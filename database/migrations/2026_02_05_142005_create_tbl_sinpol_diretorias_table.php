<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolDiretoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_diretorias', function (Blueprint $table) {
            $table->id()->autoIncrement()->comment("identificação da diretoria");
            $table->longText('conteudo')->nullable(false)->comment("conteudo do tiny mce");
            $table->string('titulo', 150)->nullable(false)->comment('titulo da diretoria');
            $table->string('slug', 155)->nullable(false)->comment("slug da diretoria");
            $table->boolean('status')->default(false)->comment("ativa ou desativa a diretoria para ser exibida no site");
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
        Schema::dropIfExists('tbl_sinpol_diretorias');
    }
}
