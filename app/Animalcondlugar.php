<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animalcondlugar extends Model
{
    protected $table = 'animalcondlugar';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
