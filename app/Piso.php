<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{
    protected $table = 'piso';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
