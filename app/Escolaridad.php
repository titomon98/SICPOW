<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escolaridad extends Model
{
    protected $table = 'escolaridad';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
