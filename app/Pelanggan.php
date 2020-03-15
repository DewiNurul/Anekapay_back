<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = "pelanggan";
    protected $fillable = [
        'nama_pelanggan',
        'email',
        'password',
        'nomor_telp',
        'nomor_kwh',
        'alamat',
        'id_tarif',
      ];
}
