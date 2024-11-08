<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolSocialMideasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_social_mideas', function (Blueprint $table) {
            $table->id()->autoIncrement()->comment("identificação da tabela");
            $table->string('titulo',155)->nullable(false)->comment("titulo da social media, obrigatório");
            $table->string('link',255)->nullable(false)->comment("link da social media, obrigatório");
            $table->string('slug',155)->nullable(false)->comment("slug , obrigatório");
            $table->boolean('status')->default(false)->comment("ativa ou desativa para ser exibido no site");
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
        Schema::dropIfExists('tbl_sinpol_social_mideas');
    }
}
