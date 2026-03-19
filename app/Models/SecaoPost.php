<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecaoPost extends Model
{
    use HasFactory;

    protected $table = 'tbl_sinpol_secao_posts';

    protected $fillable = [
        'tipo',
        'titulo',
        'conteudo',
        'status',
    ];
}
