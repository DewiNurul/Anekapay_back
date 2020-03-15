<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
    protected $table = "penggunaan";
    protected $fillable = [
        'id_pelanggan',
        'bulan',
        'tahun',
        'meter_awal',
        'meter_akhir',
      ];
}
