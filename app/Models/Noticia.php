<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'tbl_sinpol_noticias';
    protected $fillable = ['titulo', 'conteudo', 'subtitulo','status','imagem_id','destaque','slug','qtd_views','user_id', 'updated_at', 'created_at'];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function imagens()
    {
        return $this->hasMany(GaleriaImagem::class,'id','imagem_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

//    public function getUpdatedAtAttribute()
//    {
//        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
//    }

    // Crie um acessor para exibir `updated_at` formatado sem sobrescrever o original
    public function getUpdatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d/m/Y H:i:s');
    }

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d/m/Y');
    }
}
