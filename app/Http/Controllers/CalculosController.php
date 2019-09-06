<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cotizacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Diesel;
use App\Promedio;
use App\Reporte_mensual;
use App\CFA_mensual;
use App\CFO_mensual;
use App\CVM_mensual;
use App\CVO_mensual;
use App\IO_mensual;
use App\CF;
use App\CFA;
use App\CFO;
use App\CVM;
use App\CVO;
Use App\IO;
use App\Info_general;
use App\CIF_mensual;
use App\Configuracion;

class CalculosController extends Controller
{
    public static function PromediosMensuales()
    {
    	//$date = '2019-05-12';
    	//return Carbon::parse($date)->format('m');
        $cotis =  Reporte_mensual::with('cfa_mensual')->with('io_mensual')->with('cfo_mensual')->with('cvm_mensual')->with('cvo_mensual')->with('diesel')->where('año', '=', '2019')->orderby('mes')->get();

        $coti_meses = collect([]);
        $coti_meses['Enero'] = collect([]);
        $coti_meses['Febrero'] = collect([]);
        $coti_meses['Marzo'] = collect([]);
        $coti_meses['Abril'] = collect([]);
        $coti_meses['Mayo'] = collect([]);
        $coti_meses['Junio'] = collect([]);
        $coti_meses['Julio'] = collect([]);
        $coti_meses['Agosto'] = collect([]);
        $coti_meses['Septiembre'] = collect([]);
        $coti_meses['Octubre'] = collect([]);
        $coti_meses['Noviembre'] = collect([]);
        $coti_meses['Diciembre'] = collect([]);

        
        foreach ($cotis as $coti) {
            $mes = $coti->mes;

            switch ($mes) {
                case 01:
                    $coti_meses['Enero']->push($coti);
                    break;
                case 02:
                    $coti_meses['Febrero']->push($coti);
                    break;
                case 03:
                    $coti_meses['Marzo']->push($coti);
                    break;
                case 04:
                    $coti_meses['Abril']->push($coti);
                    break;
                case 05:
                    $coti_meses['Mayo']->push($coti);
                    break;
                case 06:
                    $coti_meses['Junio']->push($coti);
                    break;
                case 07:
                    $coti_meses['Julio']->push($coti);
                    break;
                case '08':
                    $coti_meses['Agosto']->push($coti);
                    break;
                case '09':
                    $coti_meses['Septiembre']->push($coti);
                    break;
                case '10':
                    $coti_meses['Octubre']->push($coti);
                    break;
                case '11':
                    $coti_meses['Noviembre']->push($coti);
                    break;
                case '12':
                    $coti_meses['Diciembre']->push($coti);
                    break;
            }
        }
        unset($cotis);

        foreach ($coti_meses as $coti2) {
            foreach ($coti2 as $coti) {
                $coti->diesel = Diesel::find($coti->diesel);
                $coti->cfa_mensual =CFA_mensual::find($coti->cfa_mensual);
                $coti->cfo_mensual = CFO_mensual::find($coti->cfo_mensual);
                $coti->cvm_mensual = CVM_mensual::find($coti->cvm_mensual);
                $coti->cvo_mensual = CVO_mensual::find($coti->cvo_mensual);
                $coti->io_mensual = IO_mensual::find($coti->io_mensual);
            }
        }

        return $coti_meses;
    }

    public static function PromedioAnual($op,$año)
    {
        $cotis =  Reporte_mensual::with('cfa_mensual')->with('io_mensual')->with('cfo_mensual')->with('cvm_mensual')->with('cvo_mensual')->with('diesel')->where('año', '=', $año)->get();


        $datos = new Reporte_mensual();
        $cvo = new CVO_mensual();
        $cfa = new CFA_mensual();
        $cfo = new CFO_mensual();
        $io = new IO_mensual();
        $cvm = new CVM_mensual();
        $diesel = new Diesel();

        if ($op == 1) {
            $div = 1;
        }
        else {
            $div = $cotis->count();
        }

        /*Problema con el with()*/
        foreach ($cotis as $coti) {
            $coti->diesel = Diesel::find($coti->diesel);
            $coti->cfa_mensual =CFA_mensual::find($coti->cfa_mensual);
            $coti->cfo_mensual = CFO_mensual::find($coti->cfo_mensual);
            $coti->cvm_mensual = CVM_mensual::find($coti->cvm_mensual);
            $coti->cvo_mensual = CVO_mensual::find($coti->cvo_mensual);
            $coti->io_mensual = IO_mensual::find($coti->io_mensual);

            $datos->sueldo_km += $coti->sueldo_km/$div;
            $datos->unidades_pagadas += $coti->unidades_pagadas/$div;
            $datos->viajes_mes += $coti->viajes_mes/$div;
            $datos->kms_unidad += $coti->kms_unidad/$div;
            $datos->viajes_unidad += $coti->viajes_unidad/$div;
            $datos->distancia_viaje += $coti->distancia_viaje/$div;
            $datos->venta_viaje += $coti->ventas_viaje/$div;
            $datos->fletes += $coti->total_ingreso/$div;
            $datos->incremento_casetas += $coti->incremento_casetas/$div;
            $datos->kms_mensuales += $coti->kms_mensuales/$div; 
            $datos->unidades_operativas += $coti->unidades_operativas/$div;
            $datos->total_costos_variables += $coti->total_costos_variables/$div;
            $datos->total_fijos_administracion += $coti->total_fijos_administracion/$div;
            $datos->uafirda += $coti->uafirda/$div;
            $datos->depreciaciones += $coti->depreciaciones/$div;
            $datos->costo_financiero += $coti->costo_financiero/$div;
            $datos->total_depreciacion_financiero += $coti->total_depreciacion_financiero/$div;
            $datos->uafir += $coti->uafir/$div;
            $datos->otros_ingresos += $coti->otros_ingresos/$div;
            $datos->productos_financieros += $coti->productos_financieros/$div;
            $datos->otros_gastos += $coti->otros_gastos/$div;
            $datos->utilidades_antes_impuestos += $coti->utilidades_antes_impuestos/$div;
            $datos->estrategia_fiscal += $coti->estrategia_fiscal/$div;
            $datos->otros_ingresos_uti += $coti->otros_ingresos_uti/$div;
            $datos->utilidades_despues_reinversion += $coti->utilidades_despues_reinversion/$div;

            $cvo->casetas_peajes += $coti->cvo_mensual->casetas_peajes/$div;
            $cvo->combustibles += $coti->cvo_mensual->combustibles/$div;
            $cvo->facilidades_admin = $coti->cvo_mensual->facilidades_admin/$div;
            $cvo->gastos_viaje += $coti->cvo_mensual->gastos_viaje/$div;
            $cvo->sueldos_operadores += $coti->cvo_mensual->sueldos_operadores/$div;
            $cvo->total += $coti->cvo_mensual->total/$div;
            $cvo->margen += $coti->cvo_mensual->margen/$div;

            $cvm->accesorios += $coti->cvm_mensual->accesorios/$div;
            $cvm->alineacion_balanceo += $coti->cvm_mensual->alineacion_balanceo/$div;
            $cvm->carroceria_pintura += $coti->cvm_mensual->carroceria_pintura/$div;
            $cvm->con_mar_tor += $coti->cvm_mensual->con_mar_tor/$div;
            $cvm->facilidades_admin += $coti->cvm_mensual->facilidades_administrativas/$div;
            $cvm->filtros += $coti->cvm_mensual->filtros/$div;
            $cvm->imagen_unidades += $coti->cvm_mensual->imagen_unidades/$div;
            $cvm->insumos_taller += $coti->cvm_mensual->insumos_taller/$div;
            $cvm->lavados_equipo += $coti->cvm_mensual->lavados_equipo/$div;
            $cvm->llantas += $coti->cvm_mensual->llantas/$div;
            $cvm->lubricantes_grasa += $coti->cvm_mensual->lubricantes_grasa/$div;
            $cvm->mano_obra += $coti->cvm_mensual->mano_obra/$div;
            $cvm->mantenimiento_preventivo += $coti->cvm_mensual->mantenimiento_preventivo/$div;
            $cvm->montaje_desmontaje += $coti->cvm_mensual->montaje_desmontaje/$div;
            $cvm->refacciones += $coti->cvm_mensual->refacciones/$div;
            $cvm->aire_acondicionado += $coti->cvm_mensual->aire_acondicionado/$div;
            $cvm->sistema_enfriamiento += $coti->cvm_mensual->sistema_enfriamiento/$div;
            $cvm->sistema_sujecion += $coti->cvm_mensual->sistema_sujecion/$div;
            $cvm->direccion_hidraulica += $coti->cvm_mensual->direccion_hidraulica/$div;
            $cvm->electrico_luces += $coti->cvm_mensual->electrico_luces/$div;
            $cvm->mecanico_motor += $coti->cvm_mensual->mecanico_motor/$div;
            $cvm->neumatico_frenos += $coti->cvm_mensual->neumatico_frenos/$div;
            $cvm->sueldos_taller += $coti->cvm_mensual->sueldos_taller/$div;
            $cvm->suspension += $coti->cvm_mensual->suspension/$div;
            $cvm->taller_externo += $coti->cvm_mensual->taller_externo/$div;
            $cvm->transmision_diferencial += $coti->cvm_mensual->transmision_diferencial/$div;
            $cvm->total += $coti->cvm_mensual->total/$div;

            $io->deducibles += $coti->io_mensual->deducibles/$div;
            $io->gestoria_federales += $coti->io_mensual->gestoria_federales/$div;
            $io->gestoria_otros += $coti->io_mensual->gestoria_otros/$div;
            $io->gestoria_SCT += $coti->io_mensual->gestoria_SCT/$div;
            $io->gruas_arrastres += $coti->io_mensual->gruas_arrastres/$div;
            $io->maniobras += $coti->io_mensual->maniobras/$div;
            $io->multas_derechos_suscripciones += $coti->io_mensual->multas_derechos_suscripciones/$div;
            $io->reparacion_cristales += $coti->io_mensual->reparacion_cristales;
            $io->total += $coti->io_mensual->total/$div;


            $cfo->arrendamiento_unidades += $coti->cfo_mensual->arrendamiento_unidades/$div;
            $cfo->corralones += $coti->cfo_mensual->corralones/$div;
            $cfo->localizacion += $coti->cfo_mensual->localizacion/$div;
            $cfo->multas_derechos_suscripciones += $coti->cfo_mensual->multas_derechos_suscripciones/$div;
            $cfo->no_deducibles += $coti->cfo_mensual->no_deducibles/$div;
            $cfo->seguros += $coti->cfo_mensual->seguros/$div;
            $cfo->sueldos_salarios += $coti->cfo_mensual->sueldos_salarios/$div;
            $cfo->sueldos_salarios_cs += $coti->cfo_mensual->sueldos_salarios_cs/$div;
            $cfo->telefonia_comunicaciones += $coti->cfo_mensual->telefonia_comunicaciones/$div;
            $cfo->uniformes_equipo += $coti->cfo_mensual->uniformes_equipo/$div;
            $cfo->total += $coti->cfo_mensual->total/$div;

            $cfa->arrendamiento += $coti->cfa_mensual->arrendamiento/$div;
            $cfa->cafeteria_despensa += $coti->cfa_mensual->cafeteria_despensa/$div;
            $cfa->computo_sistemas += $coti->cfa_mensual->computo_sistemas/$div;
            $cfa->eventos_reconocimientos += $coti->cfa_mensual->eventos_reconocimientos/$div;
            $cfa->facilidades_administrativas += $coti->cfa_mensual->facilidades_administrativas/$div;
            $cfa->gastos_viaje += $coti->cfa_mensual->gastos_viaje/$div;
            $cfa->gastos_medicos += $coti->cfa_mensual->gastos_medicos/$div;
            $cfa->impuestos += $coti->cfa_mensual->impuestos/$div;
            $cfa->multas_derechos_suscripciones += $coti->cfa_mensual->multas_derechos_suscripciones/$div;
            $cfa->papeleria_oficina += $coti->cfa_mensual->papeleria_oficina/$div;
            $cfa->reclutamiento_personal += $coti->cfa_mensual->reclutamiento_personal/$div;
            $cfa->refacciones += $coti->cfa_mensual->refacciones/$div;
            $cfa->seguros += $coti->cfa_mensual->seguros/$div;
            $cfa->servicios_ordinarios += $coti->cfa_mensual->servicios_ordinarios/$div;
            $cfa->servicios_profesionales += $coti->cfa_mensual->servicios_profesionales/$div;
            $cfa->sueldos_salarios += $coti->cfa_mensual->sueldos_salarios/$div;
            $cfa->taller_externo += $coti->cfa_mensual->taller_externo/$div;
            $cfa->telefonia_comunicaciones += $coti->cfa_mensual->telefonia_comunicaciones/$div;
            $cfa->uniformes_equipos += $coti->cfa_mensual->uniformes_equipos/$div;
            $cfa->total += $coti->cfa_mensual->total/$div;

            $diesel->precio += $coti->diesel->precio/$div;
            $diesel->iva += $coti->diesel->iva/$div;
            $diesel->precio_iva += $coti->diesel->precio_iva/$div;
        }
        $datos->cvo = $cvo;
        $datos->cvm = $cvm;
        $datos->io = $io;
        $datos->cfo = $cfo;
        $datos->cfa = $cfa;
        $datos->diesel = $diesel;
        
        return $datos;
    }

    public static function PromedioDiario($fecha)
    {

    }

    public static function AcumuladoCostos($fecha)
    {
        $fecha =  explode( '-', $fecha);
        $cotis = Cotizacion::whereMonth('fecha', $fecha[1])->whereYear('fecha', $fecha[0])->with('cf')->with('cfa')->with('cfo')->with('cvm')->with('cvo')->with('io')->get();
        $cf = new CF();
        $cfa = new CFA();
        $cfo = new CFO();
        $cvm = new CVM();
        $cvo = new CVO();
        $io = new IO();

        foreach ($cotis as $coti) {
            $coti->cvo->precio_diesel = Diesel::all()->where('id', '=', $coti->cvo->precio_diesel)->first();
            $cvo->total_diesel += $coti->cvo->total_costo_diesel;
            $cvo->autopistas += $coti->cvo->costo_autopistas;
            $cvo->sueldo += $coti->cvo->sueldo;
            $cvo->otros += $coti->cvo->otros;

            $cvm->refaccion_mo += $coti->cvm->refaccion_MO;
            $cvm->llantas += $coti->cvm->llantas;

            $io->deducibles_otros += $coti->io->deducibles_otros;

            $cfo->arrendamientos += $coti->cfo->arrendamientos;
            $cfo->seguros += $coti->cfo->seguros;
            $cfo->carga_social += $coti->cfo->carga_social;
            $cfo->otros += $coti->cfo->otros;

            $cfa->sueldos_salarios += $coti->cfa->sueldos;
            $cfa->otros +=  $coti->cfa->otros;
        }

        return ['cvo' => $cvo, 'cvm'=>$cvm, 'io'=>$io, 'cfo'=>$cfo, 'cfa'=>$cfa];
    }

    public static function NumeroACadena($mes)
    {
        $mesnum = '';

        switch ($mes) {
            case '01':
                $mesnum = 'enero';
                break;
            case '02':
                $mesnum = 'febrero';
                break;
            case '03':
                $mesnum = 'marzo';
                break;
            case '04':
                $mesnum = 'abril';
                break;
            case '05':
                $mesnum = 'mayo';
                break;
            case '06':
                $mesnum = 'junio';
                break;
            case '07':
                $mesnum = 'julio';
                break;
            case '08':
                $mesnum = 'agosto';
                break;
            case '09':
                $mesnum = 'septiembre';
                break;
            case '10':
                $mesnum = 'octubre';
                break;
            case '11':
                $mesnum = 'noviembre';
                break;
            case '12':
                $mesnum = 'diciembre';
                break;
        }

        return $mesnum;
    }

    function SacarResumen(Request $peticion)
    {
        parse_str($peticion->datos, $datos);
        $resumen = collect([]);
        $resumen['sueldo_km'] = 0;
        $resumen['unidades_pagadas'] = 0;
        $resumen['kms_mensuales'] = 0;
        $resumen['unidades_operativas'] = 0;
        $resumen['viajes_mes'] = 0;
        $resumen['kms_unidad'] = 0;
        $resumen['incremento_casetas'] = 0;
        $resumen['viajes_unidad'] = 0;
        $resumen['distancia_viaje'] = 0;
        $resumen['ventas_viaje'] = 0;

        $resumen['precio_diesel'] = 0;
        $resumen['iva'] = 0;
        $resumen['precio_iva'] = 0;

        $resumen['diesel'] = 0;
        $resumen['autopistas'] = 0;
        $resumen['sueldo'] = 0;
        $resumen['cvo_otros'] = 0;
        $resumen['cvo_total'] = 0;

        $resumen['arrendamientos'] = 0;
        $resumen['seguros'] = 0;
        $resumen['carga_social'] = 0;
        $resumen['cfo_otros'] = 0;
        $resumen['cfo_total'] = 0;

        $resumen['refaccion_mo'] = 0;
        $resumen['llantas'] = 0;
        $resumen['cvm_total'] = 0;

        $resumen['deducibles_otros'] = 0;
        $resumen['io_total'] = 0;

        $resumen['sueldos_salarios'] = 0;
        $resumen['cfa_otros'] = 0;
        $resumen['cfa_total'] = 0;

        $resumen['intereses'] = 0;
        $resumen['cif_total'] = 0;

        switch ($datos['tipo_resumen']) {
            case 'mensual':
                $fecha = explode('-', $datos['mes']);
                $reporte = Reporte_mensual::where('mes', '=', $fecha[1])->where('año', '=', $fecha[0])->first();

                $info_general = Info_general::find($reporte->info_general);
                $resumen['sueldo_km'] = $info_general['Sueldo por Km'];
                $resumen['unidades_pagadas'] = $info_general['Unidades Pagadas'];
                $resumen['kms_mensuales'] = $info_general['Kms Mensuales'];
                $resumen['unidades_operativas'] = $info_general['Unidades Operativas'];
                $resumen['viajes_mes'] = $info_general['Viajes por mes'];
                $resumen['kms_unidad'] = $info_general['Kms por unidad'];
                $resumen['viajes_unidad'] = $info_general['Viajes por unidad'];
                $resumen['distancia_viaje'] = $info_general['Distancia por viaje'];
                $resumen['ventas_viaje'] = $info_general['Venta por viaje'];
                $resumen['incremento_casetas'] = $info_general['% Incremento Casetas'];
                $resumen['precio_diesel'] = $info_general['Precio de Diesel (sin IVA)'];
                $resumen['iva'] = $info_general->iva;
                $resumen['precio_iva'] = $info_general['iva']*$info_general->iva;

                $cvo = CVO::find($reporte->cvo);
                $resumen['diesel'] = $cvo->total_costo_diesel;
                $resumen['autopistas'] = $cvo->costo_autopistas;
                $resumen['sueldo'] = $cvo->sueldo;
                $resumen['cvo_otros'] = $cvo->otros;
                $resumen['cvo_total'] = $cvo->costo;

                $cfo = CFO::find($reporte->cfo);
                $resumen['arrendamientos'] = $cfo->arrendamientos;
                $resumen['seguros'] = $cfo->seguros;
                $resumen['carga_social'] = $cfo->carga_social;
                $resumen['cfo_otros'] = $cfo->otros;
                $resumen['cfo_total'] = $cfo->costo;

                $cvm = CVM::find($reporte->cvm);
                $resumen['refaccion_mo'] = $cvm->refaccion_MO;
                $resumen['llantas'] = $cvm->llantas;
                $resumen['cvm_total'] = $cvm->costo;

                $io = IO::find($reporte->io_resumen);
                $resumen['deducibles_otros'] = $io->deducibles_otros;
                $resumen['io_total'] = $io->costo;

                $cfa = CFA::find($reporte->cfa);
                $resumen['sueldos_salarios'] = $cfa->sueldos;
                $resumen['cfa_otros'] = $cfa->otros;
                $resumen['cfa_total'] = $cfa->costo;

                $cif = CF::find($reporte->cf);
                $resumen['intereses'] = $cif->intereses;
                $resumen['cif_total'] = $cif->costo;

                return $resumen;
                break;
            case 'anual':
                $reportes = Reporte_mensual::where('año','=', $datos['año'])->get();
                foreach ($reportes as $reporte) {
                    $info_general = Info_general::find($reporte->info_general);
                    $resumen['sueldo_km'] += $info_general['Sueldo por Km'];
                    $resumen['unidades_pagadas'] += $info_general['Unidades Pagadas'];
                    $resumen['kms_mensuales'] += $info_general['Kms Mensuales'];
                    $resumen['unidades_operativas'] += $info_general['Unidades Operativas'];
                    $resumen['viajes_mes'] += $info_general['Viajes por mes'];
                    $resumen['kms_unidad'] += $info_general['Kms por unidad'];
                    $resumen['viajes_unidad'] += $info_general['Viajes por unidad'];
                    $resumen['distancia_viaje'] += $info_general['Distancia por viaje'];
                    $resumen['ventas_viaje'] += $info_general['Venta por viaje'];
                    $resumen['incremento_casetas'] += $info_general['% Incremento Casetas'];
                    $resumen['precio_diesel'] += $info_general['Precio de Diesel (sin IVA)'];
                    $resumen['iva'] += $info_general->iva;
                    $resumen['precio_iva'] += $info_general['iva']*$info_general->iva;

                    $cvo = CVO::find($reporte->cvo);
                    $resumen['diesel'] += $cvo->total_costo_diesel;
                    $resumen['autopistas'] += $cvo->costo_autopistas;
                    $resumen['sueldo'] += $cvo->sueldo;
                    $resumen['cvo_otros'] += $cvo->otros;
                    $resumen['cvo_total'] += $cvo->costo;

                    $cfo = CFO::find($reporte->cfo);
                    $resumen['arrendamientos'] += $cfo->arrendamientos;
                    $resumen['seguros'] += $cfo->seguros;
                    $resumen['carga_social'] += $cfo->carga_social;
                    $resumen['cfo_otros'] += $cfo->otros;
                    $resumen['cfo_total'] += $cfo->costo;

                    $cvm = CVM::find($reporte->cvm);
                    $resumen['refaccion_mo'] += $cvm->refaccion_MO;
                    $resumen['llantas'] += $cvm->llantas;
                    $resumen['cvm_total'] += $cvm->costo;

                    $io = IO::find($reporte->io_resumen);
                    $resumen['deducibles_otros'] += $io->deducibles_otros;
                    $resumen['io_total'] += $io->costo;

                    $cfa = CFA::find($reporte->cfa);
                    $resumen['sueldos_salarios'] += $cfa->sueldos;
                    $resumen['cfa_otros'] += $cfa->otros;
                    $resumen['cfa_total'] += $cfa->costo;

                    $cif = CF::find($reporte->cf);
                    $resumen['intereses'] += $cif->intereses;
                    $resumen['cif_total'] += $cif->costo;
                }
                break;
            case 'promedio':
                $num = count($datos['meses']);

                foreach ($datos['meses'] as $mes) {
                    $reporte = Reporte_mensual::where('año', '=', $datos['año'])->where('mes', '=', $mes)->first();
                    $info_general = Info_general::find($reporte->info_general);
                    $resumen['sueldo_km'] += $info_general['Sueldo por Km']/$num;
                    $resumen['unidades_pagadas'] += $info_general['Unidades Pagadas']/$num;
                    $resumen['kms_mensuales'] += $info_general['Kms Mensuales']/$num;
                    $resumen['unidades_operativas'] += $info_general['Unidades Operativas']/$num;
                    $resumen['viajes_mes'] += $info_general['Viajes por mes']/$num;
                    $resumen['kms_unidad'] += $info_general['Kms por unidad']/$num;
                    $resumen['viajes_unidad'] += $info_general['Viajes por unidad']/$num;
                    $resumen['distancia_viaje'] += $info_general['Distancia por viaje']/$num;
                    $resumen['ventas_viaje'] += $info_general['Venta por viaje']/$num;
                    $resumen['incremento_casetas'] += $info_general['% Incremento Casetas']/$num;
                    $resumen['precio_diesel'] += $info_general['Precio de Diesel (sin IVA)']/$num;
                    $resumen['iva'] += $info_general->iva/$num;
                    $resumen['precio_iva'] += $info_general['iva']*$info_general->iva/$num;

                    $cvo = CVO::find($reporte->cvo);
                    $resumen['diesel'] += $cvo->total_costo_diesel/$num;
                    $resumen['autopistas'] += $cvo->costo_autopistas/$num;
                    $resumen['sueldo'] += $cvo->sueldo/$num;
                    $resumen['cvo_otros'] += $cvo->otros/$num;
                    $resumen['cvo_total'] += $cvo->costo/$num;

                    $cfo = CFO::find($reporte->cfo);
                    $resumen['arrendamientos'] += $cfo->arrendamientos/$num;
                    $resumen['seguros'] += $cfo->seguros/$num;
                    $resumen['carga_social'] += $cfo->carga_social/$num;
                    $resumen['cfo_otros'] += $cfo->otros/$num;
                    $resumen['cfo_total'] += $cfo->costo/$num;

                    $cvm = CVM::find($reporte->cvm);
                    $resumen['refaccion_mo'] += $cvm->refaccion_MO/$num;
                    $resumen['llantas'] += $cvm->llantas/$num;
                    $resumen['cvm_total'] += $cvm->costo/$num;

                    $io = IO::find($reporte->io_resumen);
                    $resumen['deducibles_otros'] += $io->deducibles_otros/$num;
                    $resumen['io_total'] += $io->costo/$num;

                    $cfa = CFA::find($reporte->cfa);
                    $resumen['sueldos_salarios'] += $cfa->sueldos/$num;
                    $resumen['cfa_otros'] += $cfa->otros/$num;
                    $resumen['cfa_total'] += $cfa->costo/$num;

                    $cif = CF::find($reporte->cf);
                    $resumen['intereses'] += $cif->intereses/$num;
                    $resumen['cif_total'] += $cif->costo/$num;
                }
                break;
            case 'acumulado':
                foreach ($datos['meses'] as $mes) {
                    $reporte = Reporte_mensual::where('año','=', $datos['año'])->where('mes', '=', $mes)->first();
                    
                    $info_general = Info_general::find($reporte->info_general);
                    $resumen['sueldo_km'] += $info_general['Sueldo por Km'];
                    $resumen['unidades_pagadas'] += $info_general['Unidades Pagadas'];
                    $resumen['kms_mensuales'] += $info_general['Kms Mensuales'];
                    $resumen['unidades_operativas'] += $info_general['Unidades Operativas'];
                    $resumen['viajes_mes'] += $info_general['Viajes por mes'];
                    $resumen['kms_unidad'] += $info_general['Kms por unidad'];
                    $resumen['viajes_unidad'] += $info_general['Viajes por unidad'];
                    $resumen['distancia_viaje'] += $info_general['Distancia por viaje'];
                    $resumen['ventas_viaje'] += $info_general['Venta por viaje'];
                    $resumen['incremento_casetas'] += $info_general['% Incremento Casetas'];
                    $resumen['precio_diesel'] += $info_general['Precio de Diesel (sin IVA)'];
                    $resumen['iva'] += $info_general->iva;
                    $resumen['precio_iva'] += $info_general['iva']*$info_general->iva;

                    $cvo = CVO::find($reporte->cvo);
                    $resumen['diesel'] += $cvo->total_costo_diesel;
                    $resumen['autopistas'] += $cvo->costo_autopistas;
                    $resumen['sueldo'] += $cvo->sueldo;
                    $resumen['cvo_otros'] += $cvo->otros;
                    $resumen['cvo_total'] += $cvo->costo;

                    $cfo = CFO::find($reporte->cfo);
                    $resumen['arrendamientos'] += $cfo->arrendamientos;
                    $resumen['seguros'] += $cfo->seguros;
                    $resumen['carga_social'] += $cfo->carga_social;
                    $resumen['cfo_otros'] += $cfo->otros;
                    $resumen['cfo_total'] += $cfo->costo;

                    $cvm = CVM::find($reporte->cvm);
                    $resumen['refaccion_mo'] += $cvm->refaccion_MO;
                    $resumen['llantas'] += $cvm->llantas;
                    $resumen['cvm_total'] += $cvm->costo;

                    $io = IO::find($reporte->io_resumen);
                    $resumen['deducibles_otros'] += $io->deducibles_otros;
                    $resumen['io_total'] += $io->costo;

                    $cfa = CFA::find($reporte->cfa);
                    $resumen['sueldos_salarios'] += $cfa->sueldos;
                    $resumen['cfa_otros'] += $cfa->otros;
                    $resumen['cfa_total'] += $cfa->costo;

                    $cif = CF::find($reporte->cf);
                    $resumen['intereses'] += $cif->intereses;
                    $resumen['cif_total'] += $cif->costo;
                }
                break;
        }
        return $resumen;
    }

    /*------------------------------------Para Ajax-----------------------------*/
    public static function ObtenerMeses(Request $r)
    {
        $meses = collect([]);
        $consulta = Reporte_mensual::where('año', '=', $r->año)->get();
        if ($consulta->count()) {
            foreach ($consulta as $reporte) {
                $meses[CalculosController::NumeroACadena($reporte->mes)] = $reporte->mes;
            }

            return $meses;
        }
        else {
            return ['mensaje' => 'No se encontraron resultados'];
        }
    }

    public static function ObtenerAños()
    {
        $reportes = Reporte_mensual::all()->groupby('año');
        $años = collect([]);

        if ($reportes->count()) {
            foreach ($reportes as $key => $r) {
                $años[$key] = $key;
            }
            return $años;
        }
        else {
            return ['mensaje' => 'No se encontraron resultados'];
        }
    }

    public static function ObtenerMensual()
    {
        $año_min = Reporte_mensual::select('año')->orderby('año')->first();
        $mes_min = Reporte_mensual::select('mes')->where('año', '=', $año_min->año)->orderby('mes')->first();

        $año_max = Reporte_mensual::select('año')->orderby('año', 'desc')->first();
        $mes_max = Reporte_mensual::select('mes')->where('año', '=', $año_max->año)->orderby('mes', 'desc')->first(); 

        if ($mes_min->mes < 10) {
            $min = '0'.$mes_min->mes;
        }
        else {
            $min = $mes_min->mes;
        }

        if ($mes_max->mes < 10) {
            $max = '0'.$mes_max->mes;
        }
        else {
            $max = $mes_max->mes;
        }

        return ['min' => $año_min->año.'-'.$min, 'max' => $año_max->año.'-'.$max];
    }
}
