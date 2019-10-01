<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    protected $table = 'ambiente';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
