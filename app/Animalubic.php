<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animalubic extends Model
{
    protected $table = 'animalubic';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
