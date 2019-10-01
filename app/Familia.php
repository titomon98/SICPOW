<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Familia extends Model
{
    protected $table = 'familia';
    protected $fillable = ['fecha_inicial', 'condicion', 'sector', 'num_vivienda', 'num_familia', 'usuario', 'distrito', 'entidad_salud', 
                           'detalle_vivienda', 'created_at', 'updated_at'];

    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }

    public function distrito()
    {
        return $this->belongsTo('App\Distrito');
    }

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }

    public function detalle_vivienda()
    {
        return $this->belongsTo('App\Detalle_vivienda');
    }

    public function entidad_salud()
    {
        return $this->belongsTo('App\Entidad_salud');
    }
}