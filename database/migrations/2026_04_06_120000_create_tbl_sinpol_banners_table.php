<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_banners', function (Blueprint $table) {
            $table->id();
            $table->string('path', 255)->nullable(false)->comment("Caminho da imagem do banner");
            $table->string('titulo', 150)->nullable(true)->comment("Título opcional do banner");
            $table->string('link', 255)->nullable(true)->comment("Link opcional para onde o banner redireciona");
            $table->boolean('status')->default(false)->comment("Ativa ou desativa o banner no site");
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
        Schema::dropIfExists('tbl_sinpol_banners');
    }
}
