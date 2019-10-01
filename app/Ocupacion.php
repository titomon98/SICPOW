<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    protected $table = 'ocupacion';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
