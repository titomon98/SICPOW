<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pared extends Model
{
    protected $table = 'pared';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
