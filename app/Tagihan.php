<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = "tagihan";
    protected $fillable = [
        'id_penggunaan',
        'bulan',
        'tahun',
        'jumlah_meter',
        'status',
      ];
}
