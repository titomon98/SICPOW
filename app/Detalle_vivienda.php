<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle_vivienda extends Model
{
    protected $table = 'detalle_vivienda';
    protected $fillable = ['numvivienda', 'fecha', 'condicion', 'direccion', 'tenencia', 'tipovivienda', 'ambiente', 'cocina', 
        'techo', 'pared', 'piso', 'aguaabastecimiento', 'aguatrat', 'eliminexcretas', 'inodoro_cantidad', 'inodoro_enuso', 'inodoro_higiene',
        'eliminbasura', 'animalubic', 'animalcondlugar', 'perros', 'gatos', 'electricidad', 'telefonia', 'radio', 'otratenencia', 'otrotecho', 
        'otrapared', 'otropiso', 'otroabastagua', 'otroelimexcretas', 'otroelimbasura', 'otroservicios', 'created_at', 'updated_at'];

    public function familia()
    {
        return $this->hasMany('App\Familia');
    }

    public function tenencia()
    {
        return $this->belongsTo('App\Tenencia');
    }

    public function tipovivienda()
    {
        return $this->belongsTo('App\Tipovivienda');
    }

    public function ambiente()
    {
        return $this->belongsTo('App\Ambiente');
    }

    public function cocina()
    {
        return $this->belongsTo('App\Cocina');
    }

    public function techo()
    {
        return $this->belongsTo('App\Techo');
    }

    public function pared()
    {
        return $this->belongsTo('App\Pared');
    }

    public function piso()
    {
        return $this->belongsTo('App\Piso');
    }

    public function aguaabastecimiento()
    {
        return $this->belongsTo('App\Aguaabast');
    }

    public function aguatrat()
    {
        return $this->belongsTo('App\Aguatrat');
    }

    public function eliminexcretas()
    {
        return $this->belongsTo('App\Eliminexcretas');
    }

    public function eliminbasura()
    {
        return $this->belongsTo('App\Eliminbasura');
    }

    public function animalubic()
    {
        return $this->belongsTo('App\Animalubic');
    }

    public function animalcondlugar()
    {
        return $this->belongsTo('App\Animalcondlugar');
    }
}
