<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class etiqueta extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];
    public $timestamps = false;
    public function punto(){
        return $this->belongsToMany(punto::class, 'punto_etiquetas','etiqueta','punto');
    }
}
