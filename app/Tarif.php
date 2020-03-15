<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    protected $table = "tarif";
    protected $fillable = [
        'daya',
        'tarifperkwh',
      ];
}
