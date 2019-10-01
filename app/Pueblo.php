<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pueblo extends Model
{
    protected $table = 'pueblo';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
