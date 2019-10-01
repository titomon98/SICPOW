<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenencia extends Model
{
    protected $table = 'tenencia';
    protected $fillable = ['nombre'];

    public function detalle_vivienda()
    {
        return $this->hasMany('App\Detalle_vivienda');
    }
}
