<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Cotizacion;
use App\Ciudad;
use App\Tipo_configuracion;
use App\Estado;



class PDFController extends Controller
{
    function ReporteCotizacion()
    {
        $coti = Cotizacion::with('cliente')->with('ruta')->with('camion')->with('cvo')->with('cvm')->with('io')->with('cfo')->with('cfa')->with('cf')->first();
        $coti->ruta->ciudad_origen = Ciudad::find($coti->ruta->ciudad_origen);
        $coti->ruta->ciudad_origen->estado = Estado::find($coti->ruta->ciudad_origen->estado);

        $coti->ruta->ciudad_destino = Ciudad::find($coti->ruta->ciudad_destino);
        $coti->ruta->ciudad_destino->estado = Estado::find($coti->ruta->ciudad_destino->estado);
        $coti->camion->tipo_configuracion = Tipo_configuracion::find($coti->camion->tipo_configuracion);
        return $coti;
    	return view('pdf.reporte_cotizacion');
    }

    function ImprimirReporte()
    {
    	return PDF::loadView("pdf.reporte_cotizacion")->stream();
    	//return $pdf->download("Reporte_ventas.pdf");
    }

    function DescargarPDF($folio)
    {
        $coti = Cotizacion::with('cliente')->with('ruta')->with('camion')->with('cvo')->with('cvm')->with('io')->with('cfo')->with('cfa')->with('cf')->where('folio', '=', $folio)->first();
        $coti->ruta->ciudad_origen = Ciudad::find($coti->ruta->ciudad_origen);
        $coti->ruta->ciudad_origen->estado = Estado::find($coti->ruta->ciudad_origen->estado);

        $coti->ruta->ciudad_destino = Ciudad::find($coti->ruta->ciudad_destino);
        $coti->ruta->ciudad_destino->estado = Estado::find($coti->ruta->ciudad_destino->estado);
        $coti->camion->tipo_configuracion = Tipo_configuracion::find($coti->camion->tipo_configuracion);
        return PDF::loadView("pdf.reporte_cotizacion", compact('coti'))->download();
    }

    function VisualizarPDF($folio)
    {
        $coti = Cotizacion::with('cliente')->with('ruta')->with('camion')->with('cvo')->with('cvm')->with('io')->with('cfo')->with('cfa')->with('cf')->where('folio', '=', $folio)->first();
        $coti->ruta->ciudad_origen = Ciudad::find($coti->ruta->ciudad_origen);
        $coti->ruta->ciudad_origen->estado = Estado::find($coti->ruta->ciudad_origen->estado);

        $coti->ruta->ciudad_destino = Ciudad::find($coti->ruta->ciudad_destino);
        $coti->ruta->ciudad_destino->estado = Estado::find($coti->ruta->ciudad_destino->estado);
        $coti->camion->tipo_configuracion = Tipo_configuracion::find($coti->camion->tipo_configuracion);
        return PDF::loadView("pdf.reporte_cotizacion", compact('coti'))->stream();
    }
}
