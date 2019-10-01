<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    protected $table = 'parentesco';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
