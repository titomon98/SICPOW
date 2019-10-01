<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aguatrat extends Model
{
    protected $table = 'aguatrat';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
