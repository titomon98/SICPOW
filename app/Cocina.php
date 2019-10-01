<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cocina extends Model
{
    protected $table = 'cocina';
    protected $fillable = ['nombre', 'ubicacion'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
