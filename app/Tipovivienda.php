<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipovivienda extends Model
{
    protected $table = 'tipovivienda';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
