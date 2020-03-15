<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tagihan extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer ('id_penggunaan');
            $table->string('bulan');
            $table->string('tahun');
            $table->float('jumlah_meter');
            $table->string('status');
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
        Schema::dropIfExists('tagihan');
    }
}
