<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paismigracion extends Model
{
    protected $table = 'paismigracion';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
