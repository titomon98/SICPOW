<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entidad_salud extends Model
{
    protected $table = 'entidad_salud';
    protected $fillable = ['nombre', 'condicion'];

    public function familia()
    {
        return $this->hasMany('App\Familia');
    }
}
