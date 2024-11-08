<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table = 'tbl_sinpol_videos';
    protected $fillable = ['link','status','titulo','subtitulo','slug','updated_at', 'created_at'];
    public $timestamps = true;

    public function getCreatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedAtAttribute()
    {
        return date('d/m/Y H:i:s', strtotime($this->attributes['updated_at']));
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d/m/Y H:i:s');
    }

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d/m/Y');
    }
}
