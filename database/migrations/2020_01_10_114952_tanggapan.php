<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tanggapan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanggapan', function (BluePrint $table) {
            $table->bigIncrements('tanggapan_id');

            $table->bigInteger('keluhan_id')->index('keluhan_id_foreign');
            $table->bigInteger('petugas_id')->index('petugas_id_foreign');
            $table->enum('tanggapan', array('Diterima', 'Ditolak'))->default(null);
            $table->text('alasan', 65563);

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
        Schema::dropIfExists('tanggapan');
    }
}
