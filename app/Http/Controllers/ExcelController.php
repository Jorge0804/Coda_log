<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Referencia;
use App\Resumen;
use Illuminate\Support\Facades\DB;
 
class ExcelController extends Controller
{	
	function ObtenerMes(Request $r)
	{
		$direccion = $r->file('import_file')->getRealPath();
    	$datos = Excel::selectSheets('ER18')->load($direccion, function($reader){})->get();	
    	$reporte = collect([]);

    	foreach ($datos as $key => $fila) {
    		if($fila->estado_de_resultados == 'Total Ingreso' || $fila->estado_de_resultados == 'FLETES')
    		{
    			$reporte['enero'] = [$fila->estado_de_resultados => $fila->enero];
    			$reporte['febrero'] = [$fila->estado_de_resultados => $fila->febrero];
    			$reporte['marzo'] = [$fila->estado_de_resultados => $fila->marzo];
    			$reporte['abril'] = [$fila->estado_de_resultados => $fila->abril];
    			$reporte['mayo'] = [$fila->estado_de_resultados => $fila->mayo];
    			$reporte['junio'] = [$fila->estado_de_resultados => $fila->junio];
    			$reporte['julio'] = [$fila->estado_de_resultados => $fila->julio];
    			$reporte['agosto'] = [$fila->estado_de_resultados => $fila->agosto];
    			$reporte['septiembre'] = [$fila->estado_de_resultados => $fila->septiembre];
    			$reporte['octubre'] = [$fila->estado_de_resultados => $fila->octubre];
    			$reporte['noviembre'] = [$fila->estado_de_resultados => $fila->noviembre];
    			$reporte['diciembre'] = [$fila->estado_de_resultados => $fila->diciembre];
    		}
    	}

    	$reporte2 = collect([]);

    	foreach ($reporte as $key => $r) {
    		if ($r['Total Ingreso']) {
    			$reporte2[$key] = $r;
    		}
    	}
    	return back()->with('reporteExcel', $reporte2)->with('excel', $r);
	}

    public static function importar(Request $r)
    {
    	$mesnum = explode('-', $r->fecha)[1];
    	$mes = CalculosController::NumeroACadena($mesnum);
    	$direccion = $r->file('import_file')->getRealPath();
    	$datos = Excel::selectSheets('Estado_resultados')->load($direccion, function($reader){})->get(array('encabezados','datos', $mes));
        $encabezado = "";
        $valores = collect([]);
        //$referencias = Referencia::with('resumen')->where('resumen.encabezado', '=', 'Costo Variable de Operación')->get();

    	$reporte = collect([
            'Info General' =>[], 
            'Costo Variable de Operación' => [],
            'Costo Variable de Mantenimiento' => [],
            'Total de Costos Variables' => [],
            'Incidencias Operativas' => [],
            'Costo Fijo de Operación' => [],
            'Costo Fijo de Administracion' => [],
            'Total de Fijos y Administracion' => [],
            'Otros Gastos' => []
        ]);

        $nuevos = collect([
            'Info General' =>[], 
            'Costo Variable de Operación' => [],
            'Costo Variable de Mantenimiento' => [],
            'Total de Costos Variables' => [],
            'Incidencias Operativas' => [],
            'Costo Fijo de Operación' => [],
            'Costo Fijo de Administracion' => [],
            'Total de Fijos y Administracion' => [],
            'Otros Gastos' => []
        ]);

        $arreglo = collect([]);

    	foreach ($datos as $key => $fila) 
        {
            if ($fila->encabezados) { $encabezado = $fila->encabezados; }

            if ($encabezado && $encabezado != 'Info General' && $fila->datos && $fila->datos != 'Total Costo Variable de Operación' && $fila->datos != 'Margen de Operación' && $fila->datos != 'Total Costo Variable de Mantenimiento' && $fila->datos != 'Total de Costos Variables' && $fila->datos != 'Total Incidencias Operativas' && $fila->datos != 'Total Costo Fijo de Operación' && $fila->datos != 'Total Costo Fijo de Administracion' && $fila->datos != 'Total de Fijos y Administracion' && $fila->datos != 'Total Depreciacion y Costo Financiero' && $fila->datos != 'Total Depreciacion y Costo Financiero') {
                $referencias = Referencia::Wherehas('resumen', function($q) use($encabezado){
                    $q->where('encabezado', '=', $encabezado);
                })->get();
                $ex = 0;
                foreach ($referencias as $ref) {
                    if (trim(strtolower(str_replace('.', '', $fila->datos))) == trim(strtolower($ref->nombre))) {
                        $ex = 1;
                    }
                }
                if (!$ex) {
                    $valores->push([$encabezado => str_replace('.', '', $fila->datos)]);
                    $ex = 0;
                }
            }

    		if ($encabezado == 'Info General') {
    			$reporte['Info General'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
    		}
    		else if ($encabezado == 'Costo Variable de Operación') {
    			$reporte['Costo Variable de Operación'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
    		}
            else if ($encabezado == 'Costo Variable de Mantenimiento') {
                $reporte['Costo Variable de Mantenimiento'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
            }
            else if ($encabezado == 'Total de Costos Variables') {
                $reporte['Total de Costos Variables'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
            }
            else if ($encabezado == 'Incidencias Operativas') {
                $reporte['Incidencias Operativas'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
            }
            else if ($encabezado == 'Costo Fijo de Operación') {
                $reporte['Costo Fijo de Operación'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
            }
            else if ($encabezado == 'Costo Fijo de Administracion') {
                $reporte['Costo Fijo de Administracion'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
            }
            else if ($encabezado == 'Total de Fijos y Administracion') {
                $reporte['Total de Fijos y Administracion'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
            }
            else if ($encabezado == 'Otros Gastos') {
                $reporte['Otros Gastos'] += [str_replace('.', '', $fila->datos) => $fila->{$mes}];
            }
    	} 

        foreach ($valores as $valor) {
            foreach ($valor as $key => $v) {
                $nuevos[$key] += [$v => $v];
            }
        }
        $valores = collect([]);
        foreach ($nuevos as $key => $val) {
            if ($val) {
                $valores[$key] = $val;    
            }
        }

        $resumen = Resumen::all()->groupby('encabezado');
        $referencias = Referencia::with('resumen')->get();
    	return back()->with(['reporte' => $reporte, 'fecha' => $r->fecha, 'nuevos' => $valores, 'resumen' => $resumen, 'referencias' => $referencias]);
    }

    function RegistrarNuevosDatos(Request $r)
    {
        parse_str($r->datos, $info);

        foreach ($info as $key => $elem) {
            $var = explode('_', $key);
            $uni = implode(' ', $var);

            $resumen = Resumen::find($elem);

            $referencia = new Referencia();
            $referencia->resumen = $elem;
            $referencia->nombre = $uni;
            $referencia->save();


            switch ($resumen->encabezado) {
                case 'Costo Variable de Operación':
                    DB::select('alter table cvo_mensual add column `'.$uni.'` double default 0;');
                    break;
                case 'Costo Variable de Mantenimiento':
                    DB::select('alter table cvm_mensual add column `'.$uni.'` double default 0;');
                    break;
                case 'Incidencias Operativas':
                    DB::select('alter table io_mensual add column `'.$uni.'` double default 0;');
                    break;
                case 'Costo Fijo de Operación':
                    DB::select('alter table cfo_mensual add column `'.$uni.'` double default 0;');
                    break;
                case 'Costo Fijo de Administracion':
                    DB::select('alter table cfa_mensual add column `'.$uni.'` double default 0;');
                    break;
                case 'Costo Integral del Financiamiento':
                    DB::select('alter table cif_mensual add column `'.$uni.'` double default 0;');
                    break;
                case 'Otros Gastos':
                    DB::select('alter table otros_gastos add column `'.$uni.'` double default 0;');
                    break;
                default:
                    return ['men'=>'maaaal'];
                    break;
            }
        }
        return ['mensaje' =>'Exitoso'];
    }
}
