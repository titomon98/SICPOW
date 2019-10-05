<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Detalle_vivienda;
use App\Tenencia;
use App\Tipovivienda;
use App\Ambiente;
use App\Cocina;
use App\Techo;
use App\Pared;
use App\Piso;
use App\Aguaabast;
use App\Aguatrat;
use App\Eliminexcreteas;
use App\Eliminbasura;
use App\Animalubic;
use App\Animalcondlugar;

use Carbon\Carbon;

class ViviendaController extends Controller
{
    public function index(Request $request){

        if(!$request->ajax()) return redirect('/main');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $viviendas = Detalle_vivienda::orderBy('detalle_vivienda.id', 'asc')->paginate(10);
        }
        else{
            $viviendas = Detalle_vivienda::where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $viviendas->total(),
                'current_page' => $viviendas->currentPage(),
                'per_page'     => $viviendas->perPage(),
                'last_page'    => $viviendas->lastPage(),
                'from'         => $viviendas->firstItem(),
                'to'           => $viviendas->lastItem(),
            ],
            'viviendas' => $viviendas
        ];
    }

    public function selectTenencia(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $tenencias = Tenencia::select('id','nombre')->orderBy('id','asc')->get();
        return['tenencias'=>$tenencias];
    }

    public function selectTipovivienda(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $tipoviviendas = Tipovivienda::select('id','nombre')->orderBy('id','asc')->get();
        return['tipoviviendas'=>$tipoviviendas];
    }

    public function selectAmbiente(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $ambientes = Ambiente::select('id','nombre')->orderBy('id','asc')->get();
        return['ambientes'=>$ambientes];
    }

    public function selectCocina(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $cocinas = Cocina::select('id','nombre', 'ubicacion')->orderBy('id','asc')->get();
        return['cocinas'=>$cocinas];
    }

    public function selectTecho(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $techos = Techo::select('id','nombre')->orderBy('id','asc')->get();
        return['techos'=>$techos];
    }

    public function selectPared(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $paredes = Pared::select('id','nombre')->orderBy('id','asc')->get();
        return['paredes'=>$paredes];
    }

    public function selectPiso(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $pisos = Piso::select('id','nombre')->orderBy('id','asc')->get();
        return['pisos'=>$pisos];
    }

    public function selectAguaabast(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $aguaabasts = Aguaabast::select('id','nombre')->orderBy('id','asc')->get();
        return['aguaabasts'=>$aguaabasts];
    }

    public function selectAguatrat(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $aguatrats = Aguatrat::select('id','nombre')->orderBy('id','asc')->get();
        return['aguatrats'=>$aguatrats];
    }

    public function selectEliminexcretas(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $eliminexcreteases = Eliminexcreteas::select('id','nombre')->orderBy('id','asc')->get();
        return['eliminexcreteases'=>$eliminexcreteases];
    }

    public function selectEliminbasura(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $eliminbasuras = Eliminbasura::select('id','nombre')->orderBy('id','asc')->get();
        return['eliminbasuras'=>$eliminbasuras];
    }

    public function selectAnimalubic(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $animalubics = Animalubic::select('id','nombre')->orderBy('id','asc')->get();
        return['animalubics'=>$animalubics];
    }

    public function selectAnimalcondlugar(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $animalcondlugares = Animalcondlugar::select('id','nombre')->orderBy('id','asc')->get();
        return['animalcondlugares'=>$animalcondlugares];
    }
    public function selectVivienda(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $viviendas = Detalle_vivienda::where('condicion','=','1')
        ->select('id','numvivienda')->orderBy('numvivienda','asc')->get();
        return['viviendas'=>$viviendas];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $fechaactual = Carbon::now('America/Guatemala');
        $viviendas = new Detalle_vivienda();
        $viviendas->numvivienda = $request->numvivienda;
        $viviendas->fecha = $fechaactual->toDateString();
        $viviendas->direccion = $request->direccion;
        $viviendas->tenencia = $request->idtenencia;
        $viviendas->tipovivienda = $request->idtipovivienda;
        $viviendas->ambiente = $request->idambiente;
        $viviendas->cocina = $request->idcocina;
        $viviendas->techo = $request->idtecho;
        $viviendas->pared = $request->idpared;
        $viviendas->piso = $request->idpiso;
        $viviendas->aguaabastecimiento = $request->idaguaabast;
        $viviendas->aguatrat = $request->idaguatrat;
        $viviendas->eliminexcretas = $request->ideliminexcretas;
        $viviendas->eliminbasura = $request->ideliminbasura;
        $viviendas->animalubic = $request->idanimalubic;
        $viviendas->animalcondlugar = $request->idanimalcondlugar;
        $viviendas->perros = $request->perros;
        $viviendas->gatos = $request->gatos;
        $viviendas->electricidad = $request->electricidad;
        $viviendas->telefonia = $request->telefonia;
        $viviendas->radio = $request->radio;
        $viviendas->otratenencia = $request->otratenencia;
        $viviendas->otrotecho = $request->otrotecho;
        $viviendas->otrapared = $request->otrapared;
        $viviendas->otropiso = $request->otropiso;
        $viviendas->otroabastagua = $request->otroabastagua;
        $viviendas->otroelimexcretas = $request->otroelimexcretas;
        $viviendas->otroelimbasura = $request->otroelimbasura;
        $viviendas->otroservicios = $request->otroservicios;
        $viviendas->condicion = 1;
        $viviendas->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $fechaactual = Carbon::now('America/Guatemala');
        $viviendas = Detalle_vivienda::findOrFail($request->id);
        $viviendas->numvivienda = $request->numvivienda;
        $viviendas->fecha = $fechaactual->toDateString();
        $viviendas->direccion = $request->direccion;
        $viviendas->tenencia = $request->idtenencia;
        $viviendas->tipovivienda = $request->idtipovivienda;
        $viviendas->ambiente = $request->idambiente;
        $viviendas->cocina = $request->idcocina;
        $viviendas->techo = $request->idtecho;
        $viviendas->pared = $request->idpared;
        $viviendas->piso = $request->idpiso;
        $viviendas->aguaabastecimiento = $request->idaguaabast;
        $viviendas->aguatrat = $request->idaguatrat;
        $viviendas->eliminexcretas = $request->ideliminexcretas;
        $viviendas->eliminbasura = $request->ideliminbasura;
        $viviendas->animalubic = $request->idanimalubic;
        $viviendas->animalcondlugar = $request->idanimalcondlugar;
        $viviendas->perros = $request->perros;
        $viviendas->gatos = $request->gatos;
        $viviendas->electricidad = $request->electricidad;
        $viviendas->telefonia = $request->telefonia;
        $viviendas->radio = $request->radio;
        $viviendas->otratenencia = $request->otratenencia;
        $viviendas->otrotecho = $request->otrotecho;
        $viviendas->otrapared = $request->otrapared;
        $viviendas->otropiso = $request->otropiso;
        $viviendas->otroabastagua = $request->otroabastagua;
        $viviendas->otroelimexcretas = $request->otroelimexcretas;
        $viviendas->otroelimbasura = $request->otroelimbasura;
        $viviendas->otroservicios = $request->otroservicios;
        $viviendas->condicion = 1;
        $viviendas->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $viviendas = Detalle_vivienda::findOrFail($request->id);
        $viviendas->condicion = '0';
        $viviendas->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $viviendas = Detalle_vivienda::findOrFail($request->id);
        $viviendas->condicion = '1';
        $viviendas->save();
    }
}
