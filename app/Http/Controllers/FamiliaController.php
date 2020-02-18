<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Familia;
use App\Persona;
use App\Municipio;
use App\Comunidad;
use App\Distrito;
use App\Usuario;
use App\Entidad_Salud;
use App\Parentesco;
use App\Pueblo;
use App\Comlinguistica;
use App\Escolaridad;
use App\Discapacidad;
use App\Ocupacion;
use App\Permanencia;
use App\Paismigracion;
use App\Puesto_comunidad;


use Carbon\Carbon;

class FamiliaController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/main');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $familias = Familia::join('persona', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->join('detalle_vivienda', 'detalle_vivienda.id', '=', 'familia.detalle_vivienda')
            ->select('familia.id','familia.num_familia','familia.num_vivienda', 'familia.fecha_inicial', 'familia.sector', 'familia.condicion', 'familia.updated_at', 
                'persona.CUI', 'persona.nombres', 'persona.apellidos', //Aqui debemos concatenar nombres y apellidos
                'detalle_vivienda.numvivienda as detalle_vivienda_id', 'detalle_vivienda.direccion',
                'distrito.nombre as ubicacion1', 'comunidad.nombre as ubicacion2', 'municipio.nombre as ubicacion3') 
            ->where('persona.lider', '=', 1)
            ->orderBy('familia.id', 'asc')->paginate(10);
        }
        else{
            $familias = Familia::join('persona', 'familia.id', '=', 'persona.familia')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->join('detalle_vivienda', 'detalle_vivienda.id', '=', 'familia.detalle_vivienda')
            ->select('familia.id','familia.num_familia','familia.num_vivienda', 'familia.fecha_inicial', 'familia.sector', 'familia.condicion', 'familia.updated_at',
                'persona.CUI', 'persona.nombres', 'persona.apellidos', //Aqui debemos concatenar nombres y apellidos
                'detalle_vivienda.numvivienda as detalle_vivienda_id', 'detalle_vivienda.direccion',
                'distrito.nombre as ubicacion1', 'comunidad.nombre as ubicacion2', 'municipio.nombre as ubicacion3') 
            ->where('persona.lider', '=', 1)
            ->where('familia.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('familia.id', 'asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $familias->total(),
                'current_page' => $familias->currentPage(),
                'per_page'     => $familias->perPage(),
                'last_page'    => $familias->lastPage(),
                'from'         => $familias->firstItem(),
                'to'           => $familias->lastItem(),
            ],
            'familias' => $familias
        ];
    }

    public function obtenerFamilia(Request $request){
        if(!$request->ajax()) return redirect('/main');

        $id = $request->id;
        $familias = Familia::join('usuario', 'familia.usuario', '=', 'usuario.id')
            ->join('distrito', 'familia.distrito', '=', 'distrito.id')
            ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
            ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
            ->join('detalle_vivienda', 'detalle_vivienda.id', '=', 'familia.detalle_vivienda')
            ->join('entidad_salud', 'entidad_salud.id', '=', 'familia.entidad_salud')
            ->select('familia.id as familia_id','familia.num_familia','familia.num_vivienda', 'familia.sector', 
                'usuario.CUI', 'usuario.nombre', 'usuario.correo', 'usuario.telefono',
                'detalle_vivienda.id as detalle_vivienda_id', 'detalle_vivienda.numvivienda as num_vivienda',
                'distrito.id as distrito_id', 'distrito.nombre as nombre_distrito', 
                'comunidad.id as comunidad_id', 'comunidad.nombre as nombre_comunidad', 
                'municipio.id as municipio_id', 'municipio.nombre as nombre_municipio',
                'entidad_salud.id as entidad_salud_id', 'entidad_salud.nombre as nombre_entidad_salud') 
            ->where('familia.id', '=', $id)
            ->orderBy('familia.id', 'desc')->take(1)->get();

        return ['familias' => $familias];
    }

    public function obtenerPersonas(Request $request){
        if(!$request->ajax()) return redirect('/main');

        $id = $request->id;
        $personas = Persona::join('familia', 'persona.familia', '=', 'familia.id')
            ->join('parentesco', 'persona.parentesco', '=', 'parentesco.id')
            ->join('pueblo', 'persona.pueblo', '=', 'pueblo.id')
            ->join('comlinguistica', 'persona.comlinguistica', '=', 'comlinguistica.id')
            ->join('escolaridad', 'persona.escolaridad', '=', 'escolaridad.id')
            ->join('discapacidad', 'persona.discapacidad', '=', 'discapacidad.id')
            ->join('ocupacion', 'persona.ocupacion', '=', 'ocupacion.id')
            ->join('permanencia', 'persona.permanencia', '=', 'permanencia.id')
            ->join('paismigracion', 'persona.pais', '=', 'paismigracion.id')
            ->join('puesto_comunidad', 'persona.puesto_comunidad', '=', 'puesto_comunidad.id')
            ->select('persona.id as persona_id', 'persona.nombres', 'persona.apellidos', 'persona.apellido_casada', 'persona.sexo', 'persona.nacimiento', 
                'persona.CUI', 'persona.lider', 'persona.puesto_comunidad as puesto_comunidad_id', 'persona.parentesco as parentesco_id', 
                'persona.pueblo as pueblo_id', 'persona.comlinguistica as comlinguistica_id', 'persona.alfabetismo', 
                'persona.escolaridad as escolaridad_id', 'persona.discapacidad as discapacidad_id', 'persona.ocupacion as ocupacion_id', 
                'persona.migracion', 'persona.permanencia as permanencia_id', 'persona.commigracion', 'persona.munmigracion', 
                'persona.depmigracion', 'persona.pais as pais_id', 'persona.mortalidad', 'persona.fechamortalidad',
                'parentesco.nombre as parentesco_nombre', 'pueblo.nombre as pueblo_nombre', 'comlinguistica.nombre as comlinguistica_nombre', 
                'escolaridad.nombre as escolaridad_nombre', 'discapacidad.nombre as discapacidad_nombre', 'ocupacion.nombre as ocupacion_nombre', 
                'permanencia.nombre as permanencia_nombre', 'paismigracion.nombre as pais_nombre', 'puesto_comunidad.nombre as puestocom_nombre')
            ->where('persona.familia', '=', $id)
            ->orderBy('persona.id', 'asc')->get();

        return ['personas' => $personas];
    }

    public function selectUsuario(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $usuarios = Usuario::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['usuarios'=>$usuarios];
    }

    public function selectMunicipio(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $municipios = Municipio::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
        return['municipios'=>$municipios];
    }

    public function selectComunidad(Request $request, $id){
        if (!$request->ajax()) return redirect('/main');
        $comunidades = Comunidad::where('condicion', '=', '1')
        ->select('id', 'nombre')
        ->where('idmunicipio', '=', $id)
        ->orderBy('nombre', 'asc')->get();
        return['comunidades'=>$comunidades];
    }

    public function selectDistrito(Request $request, $id){
        if (!$request->ajax()) return redirect('/main');
        $distritos = Distrito::where('condicion', '=', '1')
        ->select('id', 'nombre')
        ->where('idcomunidad', '=', $id)
        ->orderBy('nombre', 'asc')->get();
        return['distritos'=>$distritos];
    }

    public function selectEntidadSalud(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $entidades = Entidad_salud::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['entidades'=>$entidades];
    }

    public function selectParentesco(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $parentesco = Parentesco::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['parentesco'=>$parentesco];
    }

    public function selectPueblo(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $pueblo = Pueblo::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['pueblo'=>$pueblo];
    }

    public function selectLinguistica(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $comlinguistica = Comlinguistica::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['comlinguistica'=>$comlinguistica];
    }

    public function selectEscolaridad(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $escolaridad = Escolaridad::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['escolaridad'=>$escolaridad];
    }

    public function selectDiscapacidad(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $discapacidad = Discapacidad::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['discapacidad'=>$discapacidad];
    }

    public function selectOcupacion(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $ocupacion = Ocupacion::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['ocupacion'=>$ocupacion];
    }

    public function selectPermanencia(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $permanencia = Permanencia::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['permanencia'=>$permanencia];
    }

    public function selectPais(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $pais = Paismigracion::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['pais'=>$pais];
    }

    public function selectPuestoCom(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $puestocom = Puesto_comunidad::select('id', 'nombre')->orderBy('id', 'asc')->get();
        return['puestocom'=>$puestocom];
    }

    public function store(Request $request){
        if (!$request->ajax()) return redirect('/main');

        try{
            DB::beginTransaction();
            $familias = new Familia();
            $fechaactual = Carbon::now('America/Guatemala');
            $familias->condicion = 1;
            $familias->sector = $request->sector;
            $familias->fecha_inicial = $fechaactual->toDateString();
            $familias->num_familia = $request->num_familia;
            $familias->num_vivienda = $request->num_vivienda;
            $familias->usuario = \Auth::user()->id;
            $familias->distrito = $request->distrito_id;
            $familias->entidad_salud = $request->entidad_salud_id;
            $familias->detalle_vivienda = $request->detalle_vivienda_id;
            $familias->save();

            //A partir de aqui, se guardan las personas
            $personas = $request->data; //arrayDetalle

            foreach($personas as $ep=>$per)
            {
                $persona = new Persona();
                $persona->nombres = $per['nombres'];
                $persona->apellidos = $per['apellidos'];
                $persona->apellido_casada = $per['apellido_casada'];
                $persona->lider = $per['lider'];
                $persona->sexo = $per['sexo'];
                $persona->nacimiento = $per['nacimiento'];
                $persona->CUI = $per['CUI'];
                $persona->familia = $familias->id;
                $persona->parentesco = $per['parentesco_id'];
                $persona->pueblo = $per['pueblo_id'];
                $persona->comlinguistica = $per['comlinguistica_id'];
                $persona->alfabetismo = $per['alfabetismo'];
                $persona->escolaridad = $per['escolaridad_id'];
                $persona->discapacidad = $per['discapacidad_id'];
                $persona->ocupacion = $per['ocupacion_id'];
                $persona->migracion = $per['migracion'];
                $persona->permanencia = $per['permanencia_id'];
                $persona->commigracion = $per['commigracion'];
                $persona->munmigracion = $per['munmigracion'];
                $persona->depmigracion = $per['munmigracion'];
                $persona->pais = $per['pais_id'];
                $persona->puesto_comunidad = $per['puesto_comunidad_id'];
                $persona->mortalidad = $per['mortalidad'];
                $persona->fechamortalidad = $per['fechamortalidad'];
                $persona->save();
            }

            DB::commit();
        }
        catch(Exception $error){
            DB::rollBack();
        }

        
    }

    public function update(Request $request){
        if (!$request->ajax()) return redirect('/main');

        $familias = Familia::findOrFail($request->id);
        $familias->condicion = 1;
        $familias->sector = $request->sector;
        $familias->num_familia = $request->num_familia;
        $familias->num_vivienda = $request->num_vivienda;
        $familias->usuario = \Auth::user()->id;
        $familias->distrito = $request->distrito_id;
        $familias->entidad_salud = $request->entidad_salud_id;
        $familias->detalle_vivienda = $request->detalle_vivienda_id;
        $familias->save();
    }

    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $familias = Familia::findOrFail($request->id);
        $familias->condicion = '0';
        $familias->save();

        $personas = Persona::select('id')
        ->where('familia', '=', $request->id)->get();

        foreach($personas as $ep=>$per)
        {
            $persona = Persona::findOrFail($per->id);
            $persona->mortalidad = 1;
            $persona->save();
        }

    }

    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $familias = Familia::findOrFail($request->id);
        $familias->condicion = '1';
        $familias->save();

        $personas = Persona::select('id')
        ->where('familia', '=', $request->id)->get();

        foreach($personas as $ep=>$per)
        {
            $persona = Persona::findOrFail($per->id);
            $persona->mortalidad = 0;
            $persona->save();
        }
    }

    public function nuevaPersona(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $personas = new Persona();
        $personas->nombres = $request->nombres;
        $personas->apellidos = $request->apellidos;
        $personas->apellido_casada = $request->apellido_casada;
        $personas->lider = $request->lider;
        $personas->sexo = $request->sexo;
        $personas->nacimiento = $request->nacimiento;
        $personas->CUI = $request->CUI;
        $personas->parentesco = $request->parentesco_id;
        $personas->pueblo = $request->pueblo_id;
        $personas->comlinguistica = $request->comlinguistica_id;
        $personas->alfabetismo = $request->alfabetismo;
        $personas->escolaridad = $request->escolaridad_id;
        $personas->discapacidad = $request->discapacidad_id;
        $personas->ocupacion = $request->ocupacion_id;
        $personas->migracion = $request->migracion;
        $personas->permanencia = $request->permanencia_id;
        $personas->commigracion = $request->commigracion;
        $personas->munmigracion = $request->munmigracion;
        $personas->depmigracion = $request->depmigracion;
        $personas->pais = $request->pais_id;
        $personas->puesto_comunidad = $request->puesto_comunidad_id;
        $personas->mortalidad = $request->mortalidad;
        $personas->fechamortalidad = $request->fechamortalidad;
        $personas->familia = $request->familia_id;
        $personas->save();
    }

    public function editarPersona(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $personas = Persona::findOrFail($request->id);
        $personas->nombres = $request->nombres;
        $personas->apellidos = $request->apellidos;
        $personas->apellido_casada = $request->apellido_casada;
        $personas->lider = $request->lider;
        $personas->sexo = $request->sexo;
        $personas->nacimiento = $request->nacimiento;
        $personas->CUI = $request->CUI;
        $personas->parentesco = $request->parentesco_id;
        $personas->pueblo = $request->pueblo_id;
        $personas->comlinguistica = $request->comlinguistica_id;
        $personas->alfabetismo = $request->alfabetismo;
        $personas->escolaridad = $request->escolaridad_id;
        $personas->discapacidad = $request->discapacidad_id;
        $personas->ocupacion = $request->ocupacion_id;
        $personas->migracion = $request->migracion;
        $personas->permanencia = $request->permanencia_id;
        $personas->commigracion = $request->commigracion;
        $personas->munmigracion = $request->munmigracion;
        $personas->depmigracion = $request->depmigracion;
        $personas->pais = $request->pais_id;
        $personas->puesto_comunidad = $request->puesto_comunidad_id;
        $personas->mortalidad = $request->mortalidad;
        $personas->fechamortalidad = $request->fechamortalidad;
        $personas->save();
    }

    public function desactivarPersona(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $personas = Persona::findOrFail($request->id);
        $personas->mortalidad = '1';
        $personas->save();
    }

    public function activarPersona(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $personas = Persona::findOrFail($request->id);
        $personas->mortalidad = '0';
        $personas->save();
    }
}
