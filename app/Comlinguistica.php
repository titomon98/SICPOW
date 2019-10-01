<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comlinguistica extends Model
{
    protected $table = 'comlinguistica';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
