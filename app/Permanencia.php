<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permanencia extends Model
{
    protected $table = 'permanencia';
    protected $fillable = ['nombre'];

    public function persona()
    {
        return $this->hasMany('App\Persona');
    }
}
