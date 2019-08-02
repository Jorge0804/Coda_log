<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Presupuesto;
use App\Http\Controllers\GraficaController;
use App\Http\Controllers\CalculosController;
use App\Cotizacion;
use App\Cliente;
use App\Ciudad;
use App\Estado;
use App\Camion;
use App\Tipo_configuracion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    public function __construct()
    {
    	$this->middleware('CheckLogin');
    }

    function Home()
    {
    	return view('vistas.home');
    }

    function graficas()
    {
        $grafica = GraficaController::Gpay(Cotizacion::all());
        return view('grafica', compact('grafica'));
    }

    function vercoti()
    {
        $cotis = Cotizacion::with('camion')->with('cliente')->with('ruta')->get();
        $i = 0;

        foreach ($cotis as $coti) {
            $i++;
            $ciudad = Ciudad::find($coti->ruta->ciudad_origen);
            $ciudad->estado = Estado::find($ciudad->estado);
            $coti->ruta->ciudad_origen = $ciudad;

            $ciudad = Ciudad::find($coti->ruta->ciudad_destino);
            $ciudad->estado = Estado::find($ciudad->estado);
            $coti->ruta->ciudad_destino = $ciudad;

            $coti->camion->tipo_configuracion = Tipo_configuracion::where('id', '=', $coti->camion->id)->first();
        }
        return view('cotizaciones.registrados', compact('cotis'));
    }

    function mostrarmensuales()
    {
        $datos = collect([]);
        $mensuales = CalculosController::PromediosMensuales();  
        $promedios = CalculosController::PromedioAnual(2, 2019);
        $acumulados = CalculosController::PromedioAnual(1, 2019);
        $datos=['mensuales' => $mensuales, 'promedios' => $promedios, 'acumulados' => $acumulados];
        return view('cotizaciones.promedios', compact('datos'));
    }
}
