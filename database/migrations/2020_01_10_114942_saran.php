<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Saran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saran', function (BluePrint $table) {
            $table->bigIncrements('saran_id');

            $table->integer('user_id')->index('user_id_foreign');
            $table->enum('jenis_saran', array('pelayanan', 'infrastruktur'))->default(null);
            $table->string('lokasi_saran', 255);
            $table->text('isi_saran');

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
        Schema::dropIfExists('saran');
    }
}
