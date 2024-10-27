<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'tbl_sinpol_noticias';
    protected $fillable = ['titulo', 'conteudo', 'subtitulo','status','imagem_id', 'updated_at', 'created_at'];

    public function imagens()
    {
        return $this->hasMany(GaleriaImagem::class,'id','imagem_id');
    }

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }
}
