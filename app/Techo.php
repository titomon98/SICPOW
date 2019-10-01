<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Techo extends Model
{
    protected $table = 'techo';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
