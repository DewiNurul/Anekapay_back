<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pembayaran extends Migration
{
   
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer ('id_tagihan');
            $table->date('tanggal_pembayaran');
            $table->string('bulan_bayar');
            $table->integer('biaya_admin');
            $table->integer('total_bayar');
            $table->string('status');
            $table->string('bukti');
            $table->integer('id_admin');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
}
