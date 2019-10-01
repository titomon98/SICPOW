<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discapacidad extends Model
{
    protected $table = 'discapacidad';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
