<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Keluhan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluhan', function (BluePrint $table) {
            $table->bigIncrements('keluhan_id');

            $table->bigInteger('user_id')->index('user_id_foreign');
            $table->enum('jenis_keluhan', array('pelayanan', 'infrastruktur'))->default(null);
            $table->string('lokasi_keluhan', 255);
            $table->string('foto_keluhan', 100)->nullable();
            $table->text('isi_keluhan', 65563);

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
        Schema::dropIfExists('keluhan');
    }
}
