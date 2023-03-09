<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class punto extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function etiquetas(){
        return $this->belongsToMany(etiqueta::class, 'punto_etiquetas','punto','etiqueta');
    }

}
