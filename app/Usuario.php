<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $fillable = ['nombre', 'correo', 'password', 'condicion', 'direccion', 'CUI', 'telefono', 'idrol'];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function familia()
    {
        return $this->hasMany('App\Familia');
    }

    public function rol()
    {
        return $this->belongsTo('App\Rol');
    }
}
