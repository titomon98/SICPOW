<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto_comunidad extends Model
{
    protected $table = 'puesto_comunidad';
    protected $fillable = ['nombre', 'condicion'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
