<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eliminbasura extends Model
{
    protected $table = 'eliminbasura';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
