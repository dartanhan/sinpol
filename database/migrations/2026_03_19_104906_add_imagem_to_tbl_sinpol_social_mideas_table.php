<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagemToTblSinpolSocialMideasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_sinpol_social_mideas', function (Blueprint $table) {
            $table->string('imagem')->nullable()->after('titulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_sinpol_social_mideas', function (Blueprint $table) {
            $table->dropColumn('imagem');
        });
    }
}
