<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapa extends Model
{
    use HasFactory;

    protected $table = 'tbl_sinpol_mapas';

    protected $fillable = [
        'link',
        'status',
    ];
}
