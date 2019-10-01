<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
         $prueba1=DB::table('municipio')
         ->select(DB::raw('SUM(nombre) as total'))->get();

         return ['prueba1'=>$prueba1];
    }
}
