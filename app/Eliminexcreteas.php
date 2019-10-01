<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eliminexcreteas extends Model
{
    protected $table = 'eliminexcretas';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
