<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    protected $table = 'comunidad';
    protected $fillable = ['nombre', 'condicion', 'idmunicipio'];

    public function municipio()
    {
        return $this->belongsTo('App\Municipio');
    }

    public function distrito()
    {
        return $this->hasMany('App\Distrito');
    }
}
