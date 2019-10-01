<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'distrito';
    protected $fillable = ['nombre', 'condicion', 'idcomunidad'];

    public function comunidad()
    {
        return $this->belongsTo('App\Comunidad');
    }

    public function familia()
    {
        return $this->hasMany('App\Familia');
    }
}
