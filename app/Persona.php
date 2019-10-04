<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $fillable = ['nombres', 'apellidos', 'apellido_casada', 'lider', 'sexo', 'nacimiento', 'CUI', 'familia', 'parentesco', 'pueblo', 
        'comlinguistica', 'alfabetismo', 'escolaridad', 'discapaciodad', 'ocupacion', 'migracion', 'permanencia', 'commigracion',
        'munmigracion', 'depmigracion', 'pais', 'puesto_comunidad', 'mortalidad', 'fechamortalidad'];

    public function familia()
    {
        return $this->belongsTo('App\Familia');
    }

    public function parentesco()
    {
        return $this->belongsTo('App\Parentesco');
    }

    public function pueblo()
    {
        return $this->belongsTo('App\Pueblo');
    }

    public function comlinguistica()
    {
        return $this->belongsTo('App\Comlinguistica');
    }

    public function alfabetismo()
    {
        return $this->belongsTo('App\Alfabetismo');
    }

    public function escolaridad()
    {
        return $this->belongsTo('App\Escolaridad');
    }

    public function discapacidad()
    {
        return $this->belongsTo('App\Discapacidad');
    }

    public function ocupacion()
    {
        return $this->belongsTo('App\Ocupacion');
    }

    public function migracion()
    {
        return $this->belongsTo('App\Migracion');
    }

    public function permanencia()
    {
        return $this->belongsTo('App\Permanencia');
    }

    public function pais()
    {
        return $this->belongsTo('App\Paismigracion');
    }
}
