<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = "pembayaran";
    protected $fillable = [
        'id_tagihan',
        'tanggal_pembayaran',
        'bulan_bayar',
        'biaya_admin',
        'total_bayar',
        'status',
        'bukti',
        'id_admin',
      ];
}
