<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Municipio;

class MunicipioController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/main');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $municipios = Municipio::orderBy('id', 'asc') ->paginate(10);
        }
        else{
            $municipios = Municipio::where($criterio, 'like' , '%'. $buscar . '%')->orderBy('id' , 'asc' )->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $municipios->total(),
                'current_page' => $municipios->currentPage(),
                'per_page'     => $municipios->perPage(),
                'last_page'    => $municipios->lastPage(),
                'from'         => $municipios->firstItem(),
                'to'           => $municipios->lastItem(),
            ],
            'municipios' => $municipios
        ];
    }
    public function selectMunicipio(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $municipios = Municipio::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return['municipios'=>$municipios];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $municipios = new Municipio();
        $municipios->nombre = $request->nombre;
        $municipios->condicion = 1;
        $municipios->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $municipios = Municipio::findOrFail($request->id);
        $municipios->nombre = $request->nombre;
        $municipios->condicion = 1;
        $municipios->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $municipios = Municipio::findOrFail($request->id);
        $municipios->condicion = 0;
        $municipios->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $municipios = Municipio::findOrFail($request->id);
        $municipios->condicion = 1;
        $municipios->save();
    }
}
