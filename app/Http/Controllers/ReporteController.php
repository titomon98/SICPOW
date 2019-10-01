<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Persona;
use App\Familia;
use App\Detalle_vivienda;
use App\Municipio;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    //Todos los reportes deben incluir los filtros de municipio, comunidad y sector
    //Listado de jefes de familia con direccion

    public function listarJefe(Request $request, $filtro, $id, $id2, $id3){
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $jefes=[];
        $cont=0;
        if ($filtro==1)
        {
            $jefes = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('detalle_vivienda', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito','distrito.id', '=', 'familia.distrito')
            ->join('comunidad', 'distrito.idcomunidad', '=', 'comunidad.id')
            ->join('municipio', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->select('persona.nombres', 'persona.apellidos', 'detalle_vivienda.direccion', 
            'municipio.nombre')
            ->where('persona.lider', '=' , '1')
            ->where('municipio.id', '=', $municip)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito','distrito.id', '=', 'familia.distrito')
            ->join('comunidad', 'distrito.idcomunidad', '=', 'comunidad.id')
            ->join('municipio', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->where('lider', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->count();
        }

        else if ($filtro==2)
        {
            $jefes = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('detalle_vivienda', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito','distrito.id', '=', 'familia.distrito')
            ->join('comunidad', 'distrito.idcomunidad', '=', 'comunidad.id')
            ->join('municipio', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->select('persona.nombres', 'persona.apellidos', 'detalle_vivienda.direccion', 
            'municipio.nombre')
            ->where('persona.lider', '=' , '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito','distrito.id', '=', 'familia.distrito')
            ->join('comunidad', 'distrito.idcomunidad', '=', 'comunidad.id')
            ->join('municipio', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->where('lider', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();
        }

        else if ($filtro == 3)
        {
            $jefes = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('detalle_vivienda', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito','distrito.id', '=', 'familia.distrito')
            ->join('comunidad', 'distrito.idcomunidad', '=', 'comunidad.id')
            ->join('municipio', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->select('persona.nombres', 'persona.apellidos', 'detalle_vivienda.direccion', 
            'municipio.nombre')
            ->where('persona.lider', '=' , '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito','distrito.id', '=', 'familia.distrito')
            ->join('comunidad', 'distrito.idcomunidad', '=', 'comunidad.id')
            ->join('municipio', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->where('lider', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();
        }


        $pdf = \PDF::loadView('pdf.jefes',['jefes'=>$jefes, 'cont'=>$cont, 'filtro'=>$filtro]);
        return $pdf->stream('jefes.pdf');
    }

    //Listado de vivienda habitada y deshabitada
    public function listarVivienda(Request $request, $filtro, $id, $id2, $id3)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $viviendas=[];
        $cont1=0;
        $cont2=0;

        if($filtro==1){
            $viviendas = DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.condicion', 'detalle_vivienda.direccion', 'familia.sector',
            'distrito.nombre as distrito', 'municipio.nombre as municipio', 'comunidad.nombre as comunidad')
            ->where('municipio.id', '=', $municip)
            ->orderBy('detalle_vivienda.condicion', 'asc')->get();

            $cont1=DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('detalle_vivienda.condicion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->count();

            $cont2=DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('detalle_vivienda.condicion', '=', '0')
            ->where('municipio.id', '=', $municip)
            ->count();
        }

        else if ($filtro == 2)
        {
            $viviendas = DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.condicion', 'detalle_vivienda.direccion', 'familia.sector',
            'distrito.nombre as distrito', 'municipio.nombre as municipio', 'comunidad.nombre as comunidad')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->orderBy('detalle_vivienda.condicion', 'asc')->get();

            $cont1=DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('detalle_vivienda.condicion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();

            $cont2=DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('detalle_vivienda.condicion', '=', '0')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();
        }

        else if ($filtro == 3)
        {
            $viviendas = DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.condicion', 'detalle_vivienda.direccion', 'familia.sector',
            'distrito.nombre as distrito', 'municipio.nombre as municipio', 'comunidad.nombre as comunidad')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('detalle_vivienda.condicion', 'asc')->get();

            $cont1=DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('detalle_vivienda.condicion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();

            $cont2=DB::table('detalle_vivienda')
            ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('detalle_vivienda.condicion', '=', '0')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();
        }
        

        $pdf = \PDF::loadView('pdf.viviendas',['viviendas'=>$viviendas, 'cont1'=>$cont1, 'cont2'=>$cont2]);
        return $pdf->stream('viviendas.pdf');
    }

    //listado de personas por sexo y edad
    public function listarSexo(Request $request, $filtro, $id, $id2, $id3)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $sexo=[];
        $cont1=0;
        $cont2=0;

        if($filtro==1)
        {
            $sexo = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('detalle_vivienda', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'detalle_vivienda.direccion')
            ->where('municipio.id', '=', $municip)
            ->orderBy('persona.apellidos', 'asc')->get();
    
            $cont1=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('sexo', '=', '0')
            ->where('municipio.id', '=', $municip)
            ->count();
    
            $cont2=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('sexo', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->count();
    
        }

        else if($filtro==2)
        {
            $sexo = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('detalle_vivienda', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'detalle_vivienda.direccion')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->orderBy('persona.apellidos', 'asc')->get();
    
            $cont1=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('sexo', '=', '0')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();
    
            $cont2=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('sexo', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();
        }

        else if($filtro==3)
        {
            $sexo = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('detalle_vivienda', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'detalle_vivienda.direccion')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('persona.apellidos', 'asc')->get();
    
            $cont1=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('sexo', '=', '0')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();
    
            $cont2=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('sexo', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();
        }

        
        $pdf = \PDF::loadView('pdf.sexo',['sexo'=>$sexo, 'cont1'=>$cont1, 'cont2'=>$cont2]);
        return $pdf->stream('sexo.pdf');
    }

    public function listarEdad(Request $request, $filtro, $id, $id2, $id3)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $edad=[];
        
        if($filtro==1)
        {
            $edad = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'persona.nacimiento')
            ->where('municipio.id', '=', $municip)
            ->orderBy('persona.apellidos', 'asc')->get();
        }

        else if($filtro==2)
        {
            $edad = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'persona.nacimiento')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('persona.apellidos', 'asc')->get();
        }

        else if($filtro==3)
        {
            $edad = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'persona.nacimiento')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('persona.apellidos', 'asc')->get();
        }

        $cont1=0;

        $cont2=0;

        $pdf = \PDF::loadView('pdf.edad',['edad'=>$edad, 'cont1'=>$cont1, 'cont2'=>$cont2]);
        return $pdf->stream('edad.pdf');
    }

    //listado de personas con discapacidad y cual
    public function listarDiscapacidad(Request $request, $filtro, $id, $id2, $id3)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $discapacidad=[];
        $cont1=0;
        $cont2=0;

        if($filtro==1)
        {
            $discapacidad = Persona::join('discapacidad', 'discapacidad.id', '=', 'persona.discapacidad')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'discapacidad.nombre')
            ->where('municipio.id', '=', $municip)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont1=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('discapacidad', '=', '7')
            ->where('municipio.id', '=', $municip)
            ->count();

            $cont2=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('discapacidad', '<', '7')
            ->where('municipio.id', '=', $municip)
            ->count();
        }

        else if($filtro==2)
        {
            $discapacidad = Persona::join('discapacidad', 'discapacidad.id', '=', 'persona.discapacidad')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'discapacidad.nombre')
            ->where('municipio.id', '=', $municip)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont1=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('discapacidad', '=', '7')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();

            $cont2=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('discapacidad', '<', '7')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();
        }

        else if($filtro==3)
        {
            $discapacidad = Persona::join('discapacidad', 'discapacidad.id', '=', 'persona.discapacidad')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'discapacidad.nombre')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont1=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('discapacidad', '=', '7')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();

            $cont2=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('discapacidad', '<', '7')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();
        }

        $pdf = \PDF::loadView('pdf.discapacidad',['discapacidad'=>$discapacidad, 'cont1'=>$cont1, 'cont2'=>$cont2]);
        return $pdf->stream('discapacidad.pdf');
    }

    //listado de personas por ocupacion y oficio
    public function listarOcupacion(Request $request, $filtro, $id, $id2, $id3)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $ocupacion=[];
        $cont=0;

        if ($filtro==1)
        {
            $ocupacion = Persona::join('ocupacion', 'ocupacion.id', '=', 'persona.ocupacion')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'ocupacion.nombre')
            ->where('municipio.id', '=', $municip)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('municipio.id', '=', $municip)
            ->count();
        }

        else if ($filtro==2)
        {
            $ocupacion = Persona::join('ocupacion', 'ocupacion.id', '=', 'persona.ocupacion')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'ocupacion.nombre')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();
        }

        else if ($filtro==3)
        {
            $ocupacion = Persona::join('ocupacion', 'ocupacion.id', '=', 'persona.ocupacion')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'ocupacion.nombre')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();
        }

        

        $pdf = \PDF::loadView('pdf.ocupacion',['ocupacion'=>$ocupacion, 'cont'=>$cont]);
        return $pdf->stream('ocupacion.pdf');
    }

    //listado de personas migrantes
    public function listarMigrantes(Request $request, $filtro, $id, $id2, $id3)
    {  
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $migrantes = [];
        $cont=0;
        
        if ($filtro==1)
        {
            $migrantes = Persona::join('permanencia', 'permanencia.id', '=', 'persona.permanencia')
            ->join('paismigracion', 'paismigracion.id', '=', 'persona.pais')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos',
            'permanencia.nombre', 'persona.commigracion', 'persona.munmigracion', 
            'persona.depmigracion', 'paismigracion.nombre as pais')
            ->where('persona.migracion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('persona.migracion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->count();
        }

        else if ($filtro==2)
        {
            $migrantes = Persona::join('permanencia', 'permanencia.id', '=', 'persona.permanencia')
            ->join('paismigracion', 'paismigracion.id', '=', 'persona.pais')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos',
            'permanencia.nombre', 'persona.commigracion', 'persona.munmigracion', 
            'persona.depmigracion', 'paismigracion.nombre as pais')
            ->where('persona.migracion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('persona.migracion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();
        }

        else if ($filtro==3)
        {
            $migrantes = Persona::join('permanencia', 'permanencia.id', '=', 'persona.permanencia')
            ->join('paismigracion', 'paismigracion.id', '=', 'persona.pais')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos',
            'permanencia.nombre', 'persona.commigracion', 'persona.munmigracion', 
            'persona.depmigracion', 'paismigracion.nombre as pais')
            ->where('persona.migracion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('persona.migracion', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();
        }

       

        $pdf = \PDF::loadView('pdf.migrantes', ['migrantes'=>$migrantes, 'cont'=>$cont]);
        return $pdf->stream('migrantes.pdf');

    }
    
    //listado de personas fallecidas por periodo de tiempo flexible
    public function listarFallecidos(Request $request, $filtro, $id, $id2, $id3)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $fallecidos=[];
        $cont=0;

        if($filtro==1)
        {
            $fallecidos = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 
            'persona.fechamortalidad')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->count();
        }

        else if($filtro==2)
        {
            $fallecidos = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 
            'persona.fechamortalidad')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->count();
        }

        else if($filtro==3)
        {
            $fallecidos = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 
            'persona.fechamortalidad')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->count();
        }
       

        $pdf = \PDF::loadView('pdf.fallecidos', ['fallecidos'=>$fallecidos, 'cont'=>$cont]);
        return $pdf->stream('fallecidos.pdf');

    }

    //Listado de viviendas clasificadas segun servicio que aparece en las caracteristicas
    //de vivienda y medio segun la SIGSA del 37 al 51
    public function listarServicio(Request $request, $filtro, $id, $id2, $id3, $servicio)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        //Tenencia, Tipo vivienda, separacion de ambientes
        //ubicacion de cocina, techo, pared, piso
        //abastecimiento de agua, tratamiento de aguas servidas
        //eliminacion final de excretas
        //eliminacion final de basura
        //ubicacion de los animales domesticos
        //condiciones del lugar de los animales domesticos
        //zoonosis
        //otra informacion relacionada
    }
}
