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
        $cotis = Cotizacion::with('cliente')->get();
        $grafica1 = GraficaController::Gpay($cotis);
        $grafica2 = GraficaController::Glinea($cotis);
        return view('grafica', compact('grafica1'), compact('grafica2'));
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
