<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comunidad;

class ComunidadController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/main');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $comunidades = Comunidad::join('municipio', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->select('comunidad.id', 'comunidad.nombre', 'comunidad.condicion','comunidad.idmunicipio', 'municipio.nombre as nombre_municipio')
            ->orderBy('comunidad.id', 'asc')->paginate(10);
        }
        else{
            $comunidades = Comunidad::join('municipio', 'comunidad.idmunicipio', '=', 'municipio.id')
            ->select('comunidad.id', 'comunidad.nombre', 'comunidad.condicion','comunidad.idmunicipio', 'municipio.nombre as nombre_municipio')
            ->where('comunidad.'.$criterio, 'like' , '%'. $buscar . '%')
            ->orderBy('comunidad.id', 'asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $comunidades->total(),
                'current_page' => $comunidades->currentPage(),
                'per_page'     => $comunidades->perPage(),
                'last_page'    => $comunidades->lastPage(),
                'from'         => $comunidades->firstItem(),
                'to'           => $comunidades->lastItem(),
            ],
            'comunidades' => $comunidades
        ];
    }
    public function selectComunidad(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $comunidades = Comunidad::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return['comunidades'=>$comunidades];
    }

    public function selectComunidadD(Request $request, $id){
        if (!$request->ajax()) return redirect('/main');
        $comunidades = Comunidad::select('id','nombre')
        ->where('condicion','=','1')
        ->where('idmunicipio', '=', $id)
        ->orderBy('nombre','asc')->get();
        return['comunidades'=>$comunidades];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $comunidades = new Comunidad();
        $comunidades->idmunicipio = $request->idmunicipio;
        $comunidades->nombre = $request->nombre;
        $comunidades->condicion = 1;
        $comunidades->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $comunidades = Comunidad::findOrFail($request->id);
        $comunidades->idmunicipio = $request->idmunicipio;
        $comunidades->nombre = $request->nombre;
        $comunidades->condicion = 1;
        $comunidades->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $comunidades = Comunidad::findOrFail($request->id);
        $comunidades->condicion = '0';
        $comunidades->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $comunidades = Comunidad::findOrFail($request->id);
        $comunidades->condicion = '1';
        $comunidades->save();
    }
}
