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

            $ubic=DB::table('municipio')
            ->select('municipio.nombre as municipio')
            ->where('municipio.id', '=', $municip)->get();
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

            $ubic=DB::table('municipio')
            ->select('municipio.nombre as municipio')
            ->where('municipio.id', '=', $municip)->get();

            $ubic2=DB::table('comunidad')
            ->select('comunidad.nombre as comunidad')
            ->where('comunidad.id', '=', $comuni)->get();
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

            $ubic=DB::table('municipio')
            ->join('comunidad', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->join('distrito','comunidad.id', '=', 'distrito.idcomunidad')
            ->select('municipio.nombre as municipio', 'comunidad.nombre as comunidad',
            'distrito.nombre as distrito')
            ->where('comunidad.id', '=', $comuni)
            ->where('municipio.id', '=', $municip)
            ->where('distrito.id', '=', $distri)->get();
        }


        $pdf = \PDF::loadView('pdf.jefes',['jefes'=>$jefes, 'cont'=>$cont, 'municip'=>$municip, 'comuni'=>$comuni, 'distri'=>$distri, 'ubic'=>$ubic]);
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
    //por periodo de tiempo flexible
    public function listarEdad(Request $request, $filtro, $id, $id2, $id3, $edad1, $edad2)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $edad=[];

        $anio = date('Y');

        $fecha1F = $anio - (int)$edad1; // esta va a ser el año más cercano
        $fecha2F = $anio - (int)$edad2; //esta va a ser el año más lejano
        
        if($filtro==14)
        {
            $edad = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'persona.nacimiento')
            ->where('municipio.id', '=', $municip)
            ->whereYear('persona.nacimiento', '>=', $fecha2F)
            ->whereYear('persona.nacimiento', '<=', $fecha1F)
            ->orderBy('persona.apellidos', 'asc')->get();
        }

        else if($filtro==15)
        {
            $edad = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'persona.nacimiento')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->whereYear('persona.nacimiento', '>=', $fecha2F)
            ->whereYear('persona.nacimiento', '<=', $fecha1F)
            ->orderBy('persona.apellidos', 'asc')->get();
        }

        else if($filtro==16)
        {
            $edad = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 'persona.nacimiento')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->where('distrito.id', '=', $distri)
            ->whereYear('persona.nacimiento', '>=', $fecha2F)
            ->whereYear('persona.nacimiento', '<=', $fecha1F)
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
    public function listarFallecidos(Request $request, $filtro, $id, $id2, $id3, $fecha1, $fecha2)
    {
        $municip = $id;
        $comuni = $id2;
        $distri = $id3;
        $fallecidos=[];
        $cont=0;

        if($filtro==17)
        {
            $fallecidos = Persona::join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->select('persona.nombres', 'persona.apellidos', 
            'persona.fechamortalidad')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->whereYear('persona.fechamortalidad', '>=', $fecha1)
            ->whereYear('persona.fechamortalidad', '<=', $fecha2)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->whereYear('persona.fechamortalidad', '>=', $fecha1)
            ->whereYear('persona.fechamortalidad', '<=', $fecha2)
            ->count();
        }

        else if($filtro==18)
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
            ->whereYear('persona.fechamortalidad', '>=', $fecha1)
            ->whereYear('persona.fechamortalidad', '<=', $fecha2)
            ->orderBy('persona.apellidos', 'asc')->get();

            $cont=DB::table('persona')
            ->join('familia', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->where('persona.mortalidad', '=', '1')
            ->where('municipio.id', '=', $municip)
            ->where('comunidad.id', '=', $comuni)
            ->whereYear('persona.fechamortalidad', '>=', $fecha1)
            ->whereYear('persona.fechamortalidad', '<=', $fecha2)
            ->count();
        }

        else if($filtro==19)
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
            ->whereYear('persona.fechamortalidad', '>=', $fecha1)
            ->whereYear('persona.fechamortalidad', '<=', $fecha2)
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
            ->whereYear('persona.fechamortalidad', '>=', $fecha1)
            ->whereYear('persona.fechamortalidad', '<=', $fecha2)
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
        //filtros es igual a 11, 12 y 13
        if($filtro == 11)
        {
            if($servicio == 1)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tenencia.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('tenencia.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tenencia.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tenencia";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 2)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tipovivienda', 'tipovivienda.id', '=', 'detalle_vivienda.tipovivienda')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tipovivienda.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('tipovivienda.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tipovivienda', 'tipovivienda.id', '=', 'detalle_vivienda.tipovivienda')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tipovivienda.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tipo de vivienda";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 3)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('ambiente', 'ambiente.id', '=', 'detalle_vivienda.ambiente')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'ambiente.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('ambiente.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('ambiente', 'ambiente.id', '=', 'detalle_vivienda.ambiente')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'ambiente.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Ambiente";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 4)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('cocina', 'cocina.id', '=', 'detalle_vivienda.cocina')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'cocina.nombre', 'cocina.ubicacion')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('cocina.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('cocina', 'cocina.id', '=', 'detalle_vivienda.cocina')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'cocina.nombre', 'cocina.ubicacion')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();

                $computado="Tipo de cocina";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.cocina', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('cocina.pdf');
            }

            if($servicio == 5)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('techo', 'techo.id', '=', 'detalle_vivienda.techo')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'techo.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('techo.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('techo', 'techo.id', '=', 'detalle_vivienda.techo')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'techo.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Techo";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 6)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('pared', 'pared.id', '=', 'detalle_vivienda.pared')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'pared.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('pared.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('pared', 'pared.id', '=', 'detalle_vivienda.pared')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'pared.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Pared";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 7)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('piso', 'piso.id', '=', 'detalle_vivienda.piso')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'piso.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('piso.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('piso', 'piso.id', '=', 'detalle_vivienda.piso')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'piso.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Piso";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 8)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguaabastecimiento', 'aguaabastecimiento.id', '=', 'detalle_vivienda.aguaabastecimiento')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguaabastecimiento.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('aguaabastecimiento.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguaabastecimiento', 'aguaabastecimiento.id', '=', 'detalle_vivienda.aguaabastecimiento')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguaabastecimiento.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Abastecimiento de Agua";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 9)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguatrat', 'aguatrat.id', '=', 'detalle_vivienda.aguatrat')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguatrat.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('aguatrat.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguatrat', 'aguatrat.id', '=', 'detalle_vivienda.aguatrat')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguatrat.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tratamiento de aguas";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 10)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminexcretas', 'eliminexcretas.id', '=', 'detalle_vivienda.eliminexcretas')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminexcretas.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('eliminexcretas.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminexcretas', 'eliminexcretas.id', '=', 'detalle_vivienda.eliminexcretas')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminexcretas.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Eliminacion de excretas";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 11)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminbasura', 'eliminbasura.id', '=', 'detalle_vivienda.eliminbasura')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminbasura.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('eliminbasura.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminbasura', 'eliminbasura.id', '=', 'detalle_vivienda.eliminbasura')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminbasura.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Eliminacion de basura";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 12)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalubic', 'animalubic.id', '=', 'detalle_vivienda.animalubic')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalubic.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('animalubic.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalubic', 'animalubic.id', '=', 'detalle_vivienda.animalubic')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalubic.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Ubicacion de animales";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 13)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalcondlugar', 'animalcondlugar.id', '=', 'detalle_vivienda.animalcondlugar')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalcondlugar.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('animalcondlugar.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalcondlugar', 'animalcondlugar.id', '=', 'detalle_vivienda.animalcondlugar')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalcondlugar.nombre')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Condiciones del lugar";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 14)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.perros', 'detalle_vivienda.gatos')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->orderBy('detalle_vivienda.id', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.perros', 'detalle_vivienda.gatos')
                ->where('municipio.id', '=', $municip)
                ->where('persona.lider', '=', '1')
                ->count();

                $perros=0;
                $gatos=0;
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.zoonosis', ['servicios'=>$servicios, 'cont1'=>$cont1, 'cantidad'=>$cantidad, 'gatos'=>$gatos, 'perros'=>$perros]);
                return $pdf->stream('zoonosis.pdf');
            }

            if($servicio == 15)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.electricidad', 
                'detalle_vivienda.telefonia', 'detalle_vivienda.radio')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('detalle_vivienda.radio', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.electricidad', 
                'detalle_vivienda.telefonia', 'detalle_vivienda.radio')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();

                $cantidad=0;
                $electricidad=0;
                $telefonia=0;
                $ne=0;
                $nt=0;

                $pdf = \PDF::loadView('pdf.otroservicio', ['servicios'=>$servicios, 'cont1'=>$cont1, 'cantidad'=>$cantidad, 'electricidad'=>$electricidad, 'telefonia'=>$telefonia, 'ne'=>$ne, 'nt'=>$nt]);
                return $pdf->stream('otroservicio.pdf');
            }
        }
        else if($filtro == 12)
        {
            if($servicio == 1)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tenencia.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('tenencia.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tenencia.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tenencia";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 2)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tipovivienda', 'tipovivienda.id', '=', 'detalle_vivienda.tipovivienda')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tipovivienda.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('tipovivienda.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tipovivienda', 'tipovivienda.id', '=', 'detalle_vivienda.tipovivienda')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tipovivienda.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tipo de vivienda";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 3)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('ambiente', 'ambiente.id', '=', 'detalle_vivienda.ambiente')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'ambiente.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('ambiente.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('ambiente', 'ambiente.id', '=', 'detalle_vivienda.ambiente')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'ambiente.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Ambiente";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 4)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('cocina', 'cocina.id', '=', 'detalle_vivienda.cocina')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'cocina.nombre', 'cocina.ubicacion')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('cocina.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('cocina', 'cocina.id', '=', 'detalle_vivienda.cocina')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'cocina.nombre', 'cocina.ubicacion')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();

                $computado="Tipo de cocina";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.cocina', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('cocina.pdf');
            }

            if($servicio == 5)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('techo', 'techo.id', '=', 'detalle_vivienda.techo')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'techo.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('techo.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('techo', 'techo.id', '=', 'detalle_vivienda.techo')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'techo.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Techo";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 6)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('pared', 'pared.id', '=', 'detalle_vivienda.pared')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'pared.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('pared.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('pared', 'pared.id', '=', 'detalle_vivienda.pared')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'pared.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Pared";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 7)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('piso', 'piso.id', '=', 'detalle_vivienda.piso')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'piso.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('piso.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('piso', 'piso.id', '=', 'detalle_vivienda.piso')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'piso.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Piso";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 8)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguaabastecimiento', 'aguaabastecimiento.id', '=', 'detalle_vivienda.aguaabastecimiento')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguaabastecimiento.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('aguaabastecimiento.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguaabastecimiento', 'aguaabastecimiento.id', '=', 'detalle_vivienda.aguaabastecimiento')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguaabastecimiento.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Abastecimiento de Agua";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 9)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguatrat', 'aguatrat.id', '=', 'detalle_vivienda.aguatrat')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguatrat.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('aguatrat.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguatrat', 'aguatrat.id', '=', 'detalle_vivienda.aguatrat')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguatrat.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tratamiento de aguas";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 10)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminexcretas', 'eliminexcretas.id', '=', 'detalle_vivienda.eliminexcretas')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminexcretas.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('eliminexcretas.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminexcretas', 'eliminexcretas.id', '=', 'detalle_vivienda.eliminexcretas')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminexcretas.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Eliminacion de excretas";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 11)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminbasura', 'eliminbasura.id', '=', 'detalle_vivienda.eliminbasura')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminbasura.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('eliminbasura.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminbasura', 'eliminbasura.id', '=', 'detalle_vivienda.eliminbasura')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminbasura.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Eliminacion de basura";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 12)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalubic', 'animalubic.id', '=', 'detalle_vivienda.animalubic')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalubic.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('animalubic.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalubic', 'animalubic.id', '=', 'detalle_vivienda.animalubic')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalubic.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Ubicacion de animales";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 13)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalcondlugar', 'animalcondlugar.id', '=', 'detalle_vivienda.animalcondlugar')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalcondlugar.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('animalcondlugar.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalcondlugar', 'animalcondlugar.id', '=', 'detalle_vivienda.animalcondlugar')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalcondlugar.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Condiciones del lugar";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 14)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.perros', 'detalle_vivienda.gatos')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('detalle_vivienda.id', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.perros', 'detalle_vivienda.gatos')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();

                $perros=0;
                $gatos=0;
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.zoonosis', ['servicios'=>$servicios, 'cont1'=>$cont1, 'cantidad'=>$cantidad, 'gatos'=>$gatos, 'perros'=>$perros]);
                return $pdf->stream('zoonosis.pdf');
            }

            if($servicio == 15)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.electricidad', 
                'detalle_vivienda.telefonia', 'detalle_vivienda.radio')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->orderBy('detalle_vivienda.radio', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.electricidad', 
                'detalle_vivienda.telefonia', 'detalle_vivienda.radio')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('persona.lider', '=', '1')
                ->count();

                $cantidad=0;
                $electricidad=0;
                $telefonia=0;
                $ne=0;
                $nt=0;

                $pdf = \PDF::loadView('pdf.otroservicio', ['servicios'=>$servicios, 'cont1'=>$cont1, 'cantidad'=>$cantidad, 'electricidad'=>$electricidad, 'telefonia'=>$telefonia, 'ne'=>$ne, 'nt'=>$nt]);
                return $pdf->stream('otroservicio.pdf');
            }
        }
        else if($filtro == 13)
        {
            if($servicio == 1)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tenencia.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('tenencia.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tenencia.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tenencia";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 2)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tipovivienda', 'tipovivienda.id', '=', 'detalle_vivienda.tipovivienda')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tipovivienda.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('tipovivienda.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tipovivienda', 'tipovivienda.id', '=', 'detalle_vivienda.tipovivienda')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'tipovivienda.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tipo de vivienda";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 3)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('ambiente', 'ambiente.id', '=', 'detalle_vivienda.ambiente')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'ambiente.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('ambiente.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('ambiente', 'ambiente.id', '=', 'detalle_vivienda.ambiente')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'ambiente.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Ambiente";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 4)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('cocina', 'cocina.id', '=', 'detalle_vivienda.cocina')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'cocina.nombre', 'cocina.ubicacion')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('cocina.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('cocina', 'cocina.id', '=', 'detalle_vivienda.cocina')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'cocina.nombre', 'cocina.ubicacion')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();

                $computado="Tipo de cocina";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.cocina', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('cocina.pdf');
            }

            if($servicio == 5)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('techo', 'techo.id', '=', 'detalle_vivienda.techo')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'techo.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('techo.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('techo', 'techo.id', '=', 'detalle_vivienda.techo')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'techo.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Techo";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 6)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('pared', 'pared.id', '=', 'detalle_vivienda.pared')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'pared.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('pared.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('pared', 'pared.id', '=', 'detalle_vivienda.pared')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'pared.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Pared";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 7)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('piso', 'piso.id', '=', 'detalle_vivienda.piso')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'piso.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('piso.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('piso', 'piso.id', '=', 'detalle_vivienda.piso')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'piso.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Piso";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 8)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguaabastecimiento', 'aguaabastecimiento.id', '=', 'detalle_vivienda.aguaabastecimiento')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguaabastecimiento.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('aguaabastecimiento.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguaabastecimiento', 'aguaabastecimiento.id', '=', 'detalle_vivienda.aguaabastecimiento')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguaabastecimiento.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Abastecimiento de Agua";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 9)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguatrat', 'aguatrat.id', '=', 'detalle_vivienda.aguatrat')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguatrat.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('aguatrat.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('aguatrat', 'aguatrat.id', '=', 'detalle_vivienda.aguatrat')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'aguatrat.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Tratamiento de aguas";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 10)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminexcretas', 'eliminexcretas.id', '=', 'detalle_vivienda.eliminexcretas')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminexcretas.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('eliminexcretas.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminexcretas', 'eliminexcretas.id', '=', 'detalle_vivienda.eliminexcretas')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminexcretas.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Eliminacion de excretas";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 11)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminbasura', 'eliminbasura.id', '=', 'detalle_vivienda.eliminbasura')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminbasura.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('eliminbasura.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('eliminbasura', 'eliminbasura.id', '=', 'detalle_vivienda.eliminbasura')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'eliminbasura.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Eliminacion de basura";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 12)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalubic', 'animalubic.id', '=', 'detalle_vivienda.animalubic')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalubic.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('animalubic.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalubic', 'animalubic.id', '=', 'detalle_vivienda.animalubic')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalubic.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Ubicacion de animales";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 13)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalcondlugar', 'animalcondlugar.id', '=', 'detalle_vivienda.animalcondlugar')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalcondlugar.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('animalcondlugar.nombre', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('animalcondlugar', 'animalcondlugar.id', '=', 'detalle_vivienda.animalcondlugar')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos',
                'animalcondlugar.nombre')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();
                $computado="Condiciones del lugar";
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.servicios', ['servicios'=>$servicios, 'cont1'=>$cont1, 'computado'=>$computado, 'cantidad'=>$cantidad]);
                return $pdf->stream('servicios.pdf');
            }

            if($servicio == 14)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.perros', 'detalle_vivienda.gatos')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('detalle_vivienda.id', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.perros', 'detalle_vivienda.gatos')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();

                $perros=0;
                $gatos=0;
                $cantidad=0;

                $pdf = \PDF::loadView('pdf.zoonosis', ['servicios'=>$servicios, 'cont1'=>$cont1, 'cantidad'=>$cantidad, 'gatos'=>$gatos, 'perros'=>$perros]);
                return $pdf->stream('zoonosis.pdf');
            }

            if($servicio == 15)
            {
                $servicios = DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.electricidad', 
                'detalle_vivienda.telefonia', 'detalle_vivienda.radio')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->orderBy('detalle_vivienda.radio', 'asc')->get();

                $cont1= DB::table('detalle_vivienda')
                ->join('familia', 'familia.detalle_vivienda', '=', 'detalle_vivienda.id')
                ->join('persona', 'persona.familia', '=', 'familia.id')
                ->join('distrito', 'familia.distrito', '=', 'distrito.id')
                ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
                ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
                ->join('tenencia', 'tenencia.id', '=', 'detalle_vivienda.tenencia')
                ->select('detalle_vivienda.numvivienda', 'detalle_vivienda.direccion', 
                'persona.nombres', 'persona.apellidos', 'detalle_vivienda.electricidad', 
                'detalle_vivienda.telefonia', 'detalle_vivienda.radio')
                ->where('municipio.id', '=', $municip)->where('comunidad.id', '=', $comuni)
                ->where('distrito.id', '=', $distri)
                ->where('persona.lider', '=', '1')
                ->count();

                $cantidad=0;
                $electricidad=0;
                $telefonia=0;
                $ne=0;
                $nt=0;

                $pdf = \PDF::loadView('pdf.otroservicio', ['servicios'=>$servicios, 'cont1'=>$cont1, 'cantidad'=>$cantidad, 'electricidad'=>$electricidad, 'telefonia'=>$telefonia, 'ne'=>$ne, 'nt'=>$nt]);
                return $pdf->stream('otroservicio.pdf');
            }
        }
    }
}
