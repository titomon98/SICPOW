<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Distrito;

class DistritoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/main');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $distritos = Distrito::join('comunidad', 'distrito.idcomunidad', '=', 'comunidad.id')
            ->select('distrito.id', 'distrito.nombre', 'distrito.condicion','distrito.idcomunidad', 'comunidad.nombre as nombre_comunidad')
            ->orderBy('distrito.id', 'asc')->paginate(10);
        }
        else{
            $distritos = Distrito::join('comunidad', 'distrito.idcomunidad', '=', 'comunidad.id')
            ->select('distrito.id', 'distrito.nombre', 'distrito.condicion','distrito.idcomunidad', 'comunidad.nombre as nombre_comunidad')
            ->where('distrito.'.$criterio, 'like' , '%'. $buscar . '%')
            ->orderBy('distrito.id', 'asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $distritos->total(),
                'current_page' => $distritos->currentPage(),
                'per_page'     => $distritos->perPage(),
                'last_page'    => $distritos->lastPage(),
                'from'         => $distritos->firstItem(),
                'to'           => $distritos->lastItem(),
            ],
            'distritos' => $distritos
        ];
    }
    public function selectDistrito(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $distritos = Distrito::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return['distritos'=>$distritos];
    }

    public function selectDistritoD(Request $request, $id){
        if (!$request->ajax()) return redirect('/main');
        $distritos = Distrito::where('condicion','=','1')
        ->select('id','nombre')
        ->where('distrito.idcomunidad', '=', $id)
        ->orderBy('nombre','asc')->get();
        return['distritos'=>$distritos];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $distritos = new Distrito();
        $distritos->idcomunidad = $request->idcomunidad;
        $distritos->nombre = $request->nombre;
        $distritos->condicion = 1;
        $distritos->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $distritos = Distrito::findOrFail($request->id);
        $distritos->idcomunidad = $request->idcomunidad;
        $distritos->nombre = $request->nombre;
        $distritos->condicion = 1;
        $distritos->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $distritos = Distrito::findOrFail($request->id);
        $distritos->condicion = '0';
        $distritos->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $distritos = Distrito::findOrFail($request->id);
        $distritos->condicion = '1';
        $distritos->save();
    }
}
