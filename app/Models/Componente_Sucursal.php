<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Componente_Sucursal extends Model
{
    use HasFactory;
    protected $table = 'componente_sucursal';

    public function componente(){
        return $this->belongsTo('App\Models\Componente', 'id_componente');
    }
    public function sucursal(){
        return $this->belongsTo('App\Models\Sucursal', 'id_sucursal');
    }
}