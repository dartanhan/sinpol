<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSinpolSecaoPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sinpol_secao_posts', function (Blueprint $table) {
            $table->id('id')->autoIncrement();
            $table->string('tipo', 100);
            $table->string('titulo', 255)->nullable();
            $table->longText('conteudo');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('tbl_sinpol_secao_posts');
    }
}
