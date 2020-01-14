<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahTanggapanKeluhan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->enum('tanggapan', array('ditanggapi', 'belum ditanggapi'))->default('belum ditanggapi')->after('isi_keluhan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keluhan', function (Blueprint $table) {
            $table->dropColumn('tanggapan');
        });
    }
}
