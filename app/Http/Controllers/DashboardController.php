<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
         $anio=date('Y');

         $mujeres=DB::table('persona as p')
         ->select(DB::raw('MONTH(p.created_at) as mes'),
         DB::raw('COUNT(p.sexo) as total'))
         ->whereYear('p.created_at', $anio)
         ->where('p.sexo', '=', '0')
         ->groupBy(DB::raw('MONTH(p.created_at)'), DB::raw('YEAR(p.created_at)'))
         ->get();

         $mujeresN=DB::table('persona as p')
         ->select(DB::raw('MONTH(p.nacimiento) as mes'),
         DB::raw('COUNT(p.sexo) as total'))
         ->whereYear('p.nacimiento', $anio)
         ->where('p.sexo', '=', '0')
         ->groupBy(DB::raw('MONTH(p.nacimiento)'), DB::raw('YEAR(p.nacimiento)'))
         ->get();

         $hombres=DB::table('persona as p')
         ->select(DB::raw('MONTH(p.created_at) as mes'),
         DB::raw('COUNT(p.sexo) as total'))
         ->whereYear('p.created_at', $anio)
         ->where('p.sexo', '=', '1')
         ->groupBy(DB::raw('MONTH(p.created_at)'), DB::raw('YEAR(p.created_at)'))
         ->get();

         $hombresN=DB::table('persona as p')
         ->select(DB::raw('MONTH(p.nacimiento) as mes'),
         DB::raw('COUNT(p.sexo) as total'))
         ->whereYear('p.nacimiento', $anio)
         ->where('p.sexo', '=', '1')
         ->groupBy(DB::raw('MONTH(p.nacimiento)'), DB::raw('YEAR(p.nacimiento)'))
         ->get();

         $fallecidos=DB::table('persona as p')
         ->select(DB::raw('MONTH(p.fechamortalidad) as mes'),
         DB::raw('COUNT(p.mortalidad) as fallecidos'))
         ->whereYear('p.created_at', $anio)
         ->where('p.mortalidad', '=', '1')
         ->groupBy(DB::raw('MONTH(p.fechamortalidad)'), DB::raw('YEAR(p.created_at)'))
         ->get();

         $municipios=DB::table('persona as p')
         ->join('familia', 'familia.id', '=', 'p.familia')
         ->join('distrito', 'familia.distrito', '=', 'distrito.id')
         ->join('comunidad', 'comunidad.id', '=', 'distrito.idcomunidad')
         ->join('municipio', 'municipio.id', '=', 'comunidad.idmunicipio')
         ->select(DB::raw('municipio.nombre as municipio'),
         DB::raw('COUNT(p.id) as total'))
         ->where('p.mortalidad', '=', '0')
         ->groupBy(DB::raw('municipio.nombre'))
         ->get();

         $entidad=DB::table('persona as p')
         ->join('familia', 'familia.id', '=', 'p.familia')
         ->join('entidad_salud', 'familia.entidad_salud', '=', 'entidad_salud.id')
         ->select(DB::raw('entidad_salud.nombre as entidad'),
         DB::raw('COUNT(p.id) as total'))
         ->where('p.mortalidad', '=', '0')
         ->groupBy(DB::raw('entidad_salud.nombre'))
         ->get();

         return ['mujeres'=> $mujeres, 'hombres'=>$hombres, 'anio'=>$anio, 'fallecidos'=>$fallecidos, 'municipios'=>$municipios, 'mujeresN'=>$mujeresN, 'hombresN'=>$hombresN, 'entidad'=>$entidad];
    }
}
