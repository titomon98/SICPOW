<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class UsuarioController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/main');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $usuarios = Usuario::join('rol', 'usuario.idrol', '=', 'rol.id')
            ->select('usuario.id','usuario.nombre', 'usuario.correo', 'usuario.CUI', 'usuario.direccion', 'usuario.telefono','usuario.idrol', 'rol.nombre as nombre_rol',
                'usuario.condicion')
                ->where('usuario.id', '>', '1')
            ->orderBy('usuario.id', 'asc')->paginate(10);
        }
        else{
            $usuarios = Usuario::join('rol', 'usuario.idrol', '=', 'rol.id')
            ->select('usuario.id','usuario.nombre', 'usuario.correo', 'usuario.CUI', 'usuario.direccion', 'usuario.telefono','usuario.idrol', 'rol.nombre as nombre_rol',
                'usuario.condicion')
            ->where('usuario.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('usuario.id', '>', '1')
            ->orderBy('usuario.id', 'asc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'        => $usuarios->total(),
                'current_page' => $usuarios->currentPage(),
                'per_page'     => $usuarios->perPage(),
                'last_page'    => $usuarios->lastPage(),
                'from'         => $usuarios->firstItem(),
                'to'           => $usuarios->lastItem(),
            ],
            'usuarios' => $usuarios
        ];
    }

    public function selectUsuario(Request $request){
        if (!$request->ajax()) return redirect('/main');
        $usuarios = Usuario::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return['usuarios'=>$usuarios];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $usuarios = new Usuario();
        $usuarios->idrol = $request->idrol;
        $usuarios->nombre = $request->nombre;
        $usuarios->correo = $request->correo;
        $usuarios->password = bcrypt($request->password);
        $usuarios->CUI = $request->CUI;
        $usuarios->direccion = $request->direccion;
        $usuarios->telefono = $request->telefono;
        $usuarios->condicion = 1;
        $usuarios->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $usuarios = Usuario::findOrFail($request->id);
        $usuarios->idrol = $request->idrol;
        $usuarios->nombre = $request->nombre;
        $usuarios->correo = $request->correo;
        $usuarios->password = bcrypt($request->password);
        $usuarios->CUI = $request->CUI;
        $usuarios->direccion = $request->direccion;
        $usuarios->telefono = $request->telefono;
        $usuarios->condicion = 1;
        $usuarios->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $usuarios = Usuario::findOrFail($request->id);
        $usuarios->condicion = '0';
        $usuarios->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/main');
        $usuarios = Usuario::findOrFail($request->id);
        $usuarios->condicion = '1';
        $usuarios->save();
    }
}
