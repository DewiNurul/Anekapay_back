<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Penggunaan extends Migration
{
    public function up()
    {
        Schema::create('penggunaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_pelanggan');
            $table->string('bulan');
            $table->string('tahun');
            $table->float('meter_awal');
            $table->float('meter_akhir');
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
        Schema::dropIfExists('penggunaan');
    }
}
