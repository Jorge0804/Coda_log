<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\CIF_mensual;
use App\Cliente;
use App\Periodo;
use App\Cotizacion;
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
use App\Info_general;
Use App\IO;
use App\Ciudad;
use App\Estado;
use App\Tipo_configuracion;
use App\Ruta;
use App\Camion;

use App\Resumen;
use App\Referencia;
use App\Otros_gastos;
use Alert;

class CotizacionController extends Controller
{
    /*public static function ObtenerDiesel()
    {
      $diesel = Diesel::with('periodo')->get();

      foreach ($diesel as $d) {
        $d->periodo = Periodo::find($d->periodo); 
      }

      return $diesel;
    } */

    function MostrarCotizaciones()
    {
        $cotis = Cotizacion::all();

        foreach ($cotis as $coti) {
            $ciudad_origen = Ciudad::find($coti['ruta']['ciudad_origen']);
            $ciudad_destino = Ciudad::find($coti['ruta']['ciudad_destino']);

            $ciudad_origen['estado'] = Estado::find($ciudad_origen['estado']);
            $coti['ruta']['ciudad_origen'] = $ciudad_origen;

            $ciudad_destino['estado'] = Estado::find($ciudad_destino['estado']);
            $coti['ruta']['ciudad_destino'] = $ciudad_destino;

            $coti['camion']['tipo_configuracion'] = Tipo_configuracion::where('id', '=', $coti->camion->id)->first();
        }
        return view('cotizaciones.registrados', compact('cotis'));
    }

    function FormrRegistrarMensual()
    {
      //$diesel = CotizacionController::ObtenerDiesel();
      if (count(Usuario::all())) {
        if (session('usuario')) {
          if (session('usuario')->rol == 1) {
            return view('cotizaciones.registrar'/*, compact('diesel')*/);
          } 
          elseif (session('usuario')->rol == 2) {
            return redirect('/FormCotizar');
          }
          return redirect('/CotiRegistradas');
        }
        return redirect('/');
      }
      return redirect('/FormRegistro');
    }

    function SacarResumenMensual(Request $r)
    {
        return CalculosController::AcumuladoCostos($r->fecha);
    }

    function RegistrarCoti(Request $datos)
    {
      $coti = new Cotizacion();
      $tipo = new Tipo_configuracion();
      $cvo = new CVO();
      $cvm = new CVM();
      $io = new IO();
      $cfo = new CFO();
      $cfa = new CFA();
      $cf = new CF();

      $cvo->total_costo_diesel = $datos->diesel;
      $cvo->costo_autopistas = $datos->autopistas;
      $cvo->sueldo = $datos->sueldo;
      $cvo->otros = $datos->cvo_otros;
      $cvo->costo = $datos->cvo_total;
      $cvo->save();

      $cvm->refaccion_MO = $datos->refaccion_mo;
      $cvm->llantas = $datos->llantas;
      $cvm->costo = $datos->cvm_total;
      $cvm->save();

      $io->deducibles_otros = $datos->deducibles_otros;
      $io->costo = $datos->io_total;
      $io->save();

      $cfo->arrendamientos = $datos->arrendamientos;
      $cfo->seguros = $datos->seguros;
      $cfo->carga_social = $datos->carga_social;
      $cfo->otros = $datos->cfo_otros;
      $cfo->costo = $datos->cfo_total;
      $cfo->save();

      $cfa->sueldos = $datos->sueldos_salarios;
      $cfa->otros = $datos->cfa_otros;
      $cfa->costo = $datos->cfa_total;
      $cfa->save();

      $cf->intereses = $datos->intereses;
      $cf->costo = $datos->cif_total;
      $cf->save();

      $rep_ruta = 0;
      foreach (Ruta::all() as $ruta) {
        if ($ruta->ciudad_origen == $datos->ciudad_origen && $ruta->ciudad_destino == $datos->ciudad_destino) {
          $rep_ruta = $ruta->id;
        }
      }

      if ($rep_ruta) {
        $ruta = Ruta::find($rep_ruta);
      }
      else {
        $ruta = new Ruta();

        $ruta->ciudad_origen = $datos->ciudad_origen;
        $ruta->ciudad_destino = $datos->ciudad_destino;
        $ruta->save();
      }
      $coti->fecha = date('Y-m-d');
      $coti->ruta_id = $ruta->id;
      $coti->camion_id;

      $coti->cliente_id = $datos->cliente;
      $coti->cvo_id = $cvo->id;
      $coti->cvm_id = $cvm->id;
      $coti->io_id = $io->id;
      $coti->cfo_id = $cfo->id;
      $coti->cfa_id = $cfa->id;
      $coti->cf_id = $cf->id;
      $coti->usuario_id = session('usuario')->id;
      if ($datos->tipo == 1) {
        $coti->tipo = 'Un sentido';
      }
      else if ($datos->tipo == 2) {
        $coti->tipo = 'Doble sentido';
      }
      $coti->camion_id = Camion::where('tipo_configuracion', '=', $datos->tipo)->first()->id;
      $coti->flete = $datos->flete;
      $coti->precio_km = $datos->precio_km;
      $coti->litro_diesel = $datos->litro_diesel;
      $coti->estado = $datos->status;
      $coti->kilometros_ida = $datos->km_uno;
      $coti->presupuesto_viajes = $datos->presupuesto;
      $coti->rendimiento_diesel = $datos->rendimiento;
      $coti->costo_pista = $datos->un_sentido;
      $coti->total_kilometros = $datos->km_redondo;
      $coti->sueldo_kilometro = $datos->sueldo_km;
      $coti->costo_viaje = $datos->costo_viaje;
      $coti->utilidad_viaje = $datos->utilidad;
      $coti->tkm_mensual = $datos->km_mensuales;
      $coti->litros_diesel = $datos->litros_diesel;
      $coti->venta_kilometro = $datos->venta_km;
      $coti->costo_kilometro = $datos->costo_kilometro;
      $coti->utilidad_kilometro = $datos->utilidad_kilometro;
      $coti->ingreso = $datos->ingresos_viaje;
      $coti->utilidad_operativa = $datos->utilidad_operacion;
      $coti->save();

      return back();
    }

    function VerificarReporte(Request $r)
    {
      $array_fecha = explode('-', $r->datos);
      return ['resultado' => Reporte_mensual::where('año', '=', $array_fecha[0])->where('mes', '=', $array_fecha[1])->get()->count()];
    }

    function RegistrarMensual(Request $res)
    { 
      parse_str($res->datos, $r);
      $cf = new CF();
      $info = new Info_general();
      $cfa = new  CFA();
      $cfa_mensual = new CFA_mensual();
      $cfo = new CFO();
      $cfo_mensual = new CFO_mensual();
      $cvm = new CVM();
      $cvm_mensual = new CVM_mensual();
      $cvo = new CVO();
      $cvo_mensual = new CVO_mensual();
      $io = new IO();
      $cif_mensual = new cif_mensual();
      $IO_mensual = new IO_mensual();
      $rep = new Reporte_mensual();
      $otros = new Otros_gastos();

      foreach ($r['Costo_Variable_de_Operación'] as $key => $value) {
        $cvo_mensual[trim($key)] = $value;
      }
      $cvo_mensual->save();
      foreach ($r['Costo_Variable_de_Mantenimiento'] as $key => $value) {
        $cvm_mensual[trim($key)] = $value;
      }
      $cvm_mensual->save();
      foreach ($r['Incidencias_Operativas'] as $key => $value) {
        $IO_mensual[trim($key)] = $value;
      }
      $IO_mensual->save();
      foreach ($r['Info_General'] as $key => $value) {
        $info[trim($key)] = $value;
      }
      $info->save();
      foreach ($r['Costo_Fijo_de_Operación'] as $key => $value) {
        $cfo_mensual[trim($key)] = $value;
      }
      $cfo_mensual->save();
      foreach ($r['Costo_Fijo_de_Administracion'] as $key => $value) {
        $cfa_mensual[trim($key)] = $value;
      }
      $cfa_mensual->save();
      foreach ($r['Otros_Gastos'] as $key => $value) {
        $otros[trim($key)] = $value;
      }
      $otros->save();
      $cif_mensual->intereses = $r['Otros_Gastos']['Costo Financiero'];
      $cif_mensual->save();

      $cvo->costo = $r['Resumen_Costo_Variable_de_Operación']['total'];
      $cvo->total_costo_diesel = $r['Resumen_Costo_Variable_de_Operación']['Diesel'];
      $cvo->costo_autopistas = $r['Resumen_Costo_Variable_de_Operación']['Autopistas'];
      $cvo->sueldo = $r['Resumen_Costo_Variable_de_Operación']['Sueldo'];
      $cvo->otros = $r['Resumen_Costo_Variable_de_Operación']['Otros'];
      $cvo->save();

      $cvm->costo = $r['Resumen_Costo_Variable_de_Mantenimiento']['total'];
      $cvm->refaccion_MO = $r['Resumen_Costo_Variable_de_Mantenimiento']['Refacciones y MO'];
      $cvm->llantas = $r['Resumen_Costo_Variable_de_Mantenimiento']['Llantas'];
      $cvm->save();

      $io->costo = $r['Resumen_Incidencias_Operativas']['total'];
      $io->deducibles_otros = $r['Resumen_Incidencias_Operativas']['Deducibles y Otros'];
      $io->save();

      $cfo->costo = $r['Resumen_Costo_Fijo_de_Operación']['total'];
      $cfo->arrendamientos = $r['Resumen_Costo_Fijo_de_Operación']['Arrendamientos'];
      $cfo->seguros = $r['Resumen_Costo_Fijo_de_Operación']['Seguros'];
      $cfo->carga_social = $r['Resumen_Costo_Fijo_de_Operación']['Carga Social']; 
      $cfo->otros = $r['Resumen_Costo_Fijo_de_Operación']['Otros'];
      $cfo->save();

      $cfa->costo = $r['Resumen_Costo_Fijo_de_Administracion']['total'];
      $cfa->sueldos = $r['Resumen_Costo_Fijo_de_Administracion']['Sueldos y Salarios'];
      $cfa->otros = $r['Resumen_Costo_Fijo_de_Administracion']['Otros'];
      $cfa->save();

      $cf->costo = $r['Resumen_Costo_Integral_del_Financiamiento']['total'];
      $cf->intereses = $r['Resumen_Costo_Integral_del_Financiamiento']['Intereses'];
      $cf->save();

      $rep->cvo_mensual = $cvo_mensual->id;
      $rep->cvm_mensual = $cvm_mensual->id;
      $rep->io_mensual = $IO_mensual->id;
      $rep->cfo_mensual = $cfo_mensual->id;
      $rep->cfa_mensual = $cfa_mensual->id;
      $rep->cif_mensual = $cif_mensual->id;
      $rep->otros_gastos = $otros->id;
      $rep->cvo = $cvo->id;
      $rep->cvm = $cvm->id;
      $rep->io_resumen = $io->id;
      $rep->cfo = $cfo->id;
      $rep->cfa = $cfa->id;
      $rep->cf = $cf->id;
      $rep->info_general = $info->id;
      $fecha = explode('-', $r['fecha_reg']);
      $rep->mes = $fecha[1];
      $rep->año = $fecha[0];
      $rep->save();
      return ['accion' => 'Nuevo'];
    }

    function ActualizarReporte(Request $res)
    {
      parse_str($res->datos, $r);
      $array_fecha = explode('-', $r['fecha_reg']);
      $existente = Reporte_mensual::where('año', '=', $array_fecha[0])->where('mes', '=', $array_fecha[1])->first();

      $cf = CF::find($existente->cf);
      $info = Info_general::find($existente->info_general);
      $cfa = CFA::find($existente->cfa);
      $cfa_mensual = CFA_mensual::find($existente->cfa_mensual);
      $cfo = CFO::find($existente->cfo);
      $cfo_mensual = CFO_mensual::find($existente->cfo_mensual);
      $cvm = CVM::find($existente->cvm);
      $cvm_mensual = CVM_mensual::find($existente->cvm_mensual);
      $cvo = CVO::find($existente->cvo);
      $cvo_mensual = CVO_mensual::find($existente->cvo_mensual);
      $io = IO::find($existente->io_resumen);
      $cif_mensual = cif_mensual::find($existente->cif_mensual);
      $IO_mensual = IO_mensual::find($existente->io_mensual);
      $otros = Otros_gastos::find($existente->otros_gastos);

      foreach ($r['Costo_Variable_de_Operación'] as $key => $value) {
        $cvo_mensual[trim($key)] = $value;
      }
      $cvo_mensual->update();
      foreach ($r['Costo_Variable_de_Mantenimiento'] as $key => $value) {
        $cvm_mensual[trim($key)] = $value;
      }
      $cvm_mensual->update();
      foreach ($r['Incidencias_Operativas'] as $key => $value) {
        $IO_mensual[trim($key)] = $value;
      }
      $IO_mensual->update();
      foreach ($r['Info_General'] as $key => $value) {
        $info[trim($key)] = $value;
      }
      $info->update();
      foreach ($r['Costo_Fijo_de_Operación'] as $key => $value) {
        $cfo_mensual[trim($key)] = $value;
      }
      $cfo_mensual->update();
      foreach ($r['Costo_Fijo_de_Administracion'] as $key => $value) {
        $cfa_mensual[trim($key)] = $value;
      }
      $cfa_mensual->update();
      foreach ($r['Otros_Gastos'] as $key => $value) {
        $otros[trim($key)] = $value;
      }
      $otros->update();
      $cif_mensual->intereses = $r['Otros_Gastos']['Costo Financiero'];
      $cif_mensual->update();

      $cvo->costo = $r['Resumen_Costo_Variable_de_Operación']['total'];
      $cvo->total_costo_diesel = $r['Resumen_Costo_Variable_de_Operación']['Diesel'];
      $cvo->costo_autopistas = $r['Resumen_Costo_Variable_de_Operación']['Autopistas'];
      $cvo->sueldo = $r['Resumen_Costo_Variable_de_Operación']['Sueldo'];
      $cvo->otros = $r['Resumen_Costo_Variable_de_Operación']['Otros'];
      $cvo->update();

      $cvm->costo = $r['Resumen_Costo_Variable_de_Mantenimiento']['total'];
      $cvm->refaccion_MO = $r['Resumen_Costo_Variable_de_Mantenimiento']['Refacciones y MO'];
      $cvm->llantas = $r['Resumen_Costo_Variable_de_Mantenimiento']['Llantas'];
      $cvm->update();

      $io->costo = $r['Resumen_Incidencias_Operativas']['total'];
      $io->deducibles_otros = $r['Resumen_Incidencias_Operativas']['Deducibles y Otros'];
      $io->update();

      $cfo->costo = $r['Resumen_Costo_Fijo_de_Operación']['total'];
      $cfo->arrendamientos = $r['Resumen_Costo_Fijo_de_Operación']['Arrendamientos'];
      $cfo->seguros = $r['Resumen_Costo_Fijo_de_Operación']['Seguros'];
      $cfo->carga_social = $r['Resumen_Costo_Fijo_de_Operación']['Carga Social']; 
      $cfo->otros = $r['Resumen_Costo_Fijo_de_Operación']['Otros'];
      $cfo->update();

      $cfa->costo = $r['Resumen_Costo_Fijo_de_Administracion']['total'];
      $cfa->sueldos = $r['Resumen_Costo_Fijo_de_Administracion']['Sueldos y Salarios'];
      $cfa->otros = $r['Resumen_Costo_Fijo_de_Administracion']['Otros'];
      $cfa->update();

      $cf->costo = $r['Resumen_Costo_Integral_del_Financiamiento']['total'];
      $cf->intereses = $r['Resumen_Costo_Integral_del_Financiamiento']['Intereses'];
      $cf->update();

      $fecha = explode('-', $r['fecha_reg']);
      $existente->mes = $fecha[1];
      $existente->año = $fecha[0];
      $existente->update();
      return ['accion' => 'Actualizado']; 
    }

    function FormCotizar()
    {
      $clientes = Cliente::orderby('nombre')->get();
      $estados = Estado::with('ciudades')->orderby('nombre')->get();
      $configuraciones = Tipo_configuracion::all();

      $datos = [
        'clientes'=>$clientes,
        'estados'=>$estados,
        'configuraciones'=>$configuraciones
      ];
      if (count(Usuario::all())) {
       if (session('usuario')) {
         if (session('usuario')->rol != 3) {
          return view('cotizaciones.cotizar', compact('datos'));
        } 
        return redirect('/CotiRegistradas');
       }
       return redirect('/');
      }
      return redirect('/FormRegistro');
    }

    //Funciones de registro

    function AgregarCliente(Request $datos)
    {
      $rep = true;
      parse_str($datos->datos, $data);
      foreach (Cliente::All() as $cliente) {
        if (strtolower($cliente->nombre) == strtolower($data['cliente'])) {
          $rep = false;
        }
      }

      if ($rep) {
        $cliente = new Cliente();
        $cliente->nombre = $data['cliente'];
        $cliente->save();

        return [
          'mensaje' => $cliente->nombre.' ha sido registrado con éxito',
          'cliente' => $cliente,
          'dato' => 'cliente',
          'tipo' => 'registrado'
        ];
      }
      return [
        'mensaje' => 'Este cliente ya existe',
        'dato' => 'cliente', 
        'tipo' => 'repetido'
      ];
    }

    /*function AgregarConfiguracion(Request $datos)
    {
      $rep = true;
      foreach (Tipo_configuracion::all() as $config) {
        if (strtolower($config->configuracion) == strtolower($datos->config)) {
          $rep = false;
        }
      }

      if ($rep) {
        $config = new Tipo_configuracion();
        $config->configuracion = $datos->config;
        $config->save();

        return $config;
      }
      return ['repetido' => 'Este cliente no se puede registrar debido a que ya existe'];
    }*/

    function AgregarCiudad(Request $datos)
    {
      parse_str($datos->datos, $data);
      $id_estado;
      $est_nuevo = false;
      if ($data['radio_estado']) {
        $rep = true;
        foreach (Estado::All() as $estado) {
          if (strtolower($estado->nombre) == strtolower($data['nuevo_estado'])) {
            $rep = false;
          }
        }
        
        if ($rep) {
          $estado = new Estado();
          $estado->nombre = $data['nuevo_estado'];
          $estado->save();

          $id_estado = $estado->id;
          $est_nuevo = true;
        }
        else {
          return [
            'tipo' => 'repetido',
            'mensaje' => 'Este estado ya existe',
            'dato' => 'ciudad'
          ];
        }
      }
      else {
        $id_estado = $data['estado'];
      }

      $rep = true;

      foreach (Ciudad::where('estado', '=', $id_estado)->get() as $ciudad) {
        if (strtolower($ciudad->nombre) == strtolower($data['ciudad'])) {
          $rep = false;
        }
      }

      if ($rep) {
        $ciudad = new Ciudad();
        $ciudad->nombre = $data['ciudad'];
        $ciudad->estado = $id_estado;
        $ciudad->save();

        if ($est_nuevo) {
          return [
            'tipo' => 'registrado',
            'mensaje' => 'El registro del estado y la ciudad fue exitoso',
            'ciudad' => $ciudad,
            'estados' => json_encode(Estado::with('ciudades')->get()),
            'dato' => 'ciudad'
          ];
        } 
        else {
          return [
            'tipo' => 'registrado',
            'mensaje' => 'La ciudad de '.$ciudad->nombre.' ha sido registrada',
            'ciudad' => $ciudad,
            'dato' => 'ciudad'
          ];
        }
      }
      return [
        'tipo' => 'repetido',
        'mensaje' => 'La ciudad de '.$data['ciudad'].' ya está registrada para este estado',
        'dato' => 'ciudad'
      ];
    }

    function EliminarCotización(Request $r)
    {
      Cotizacion::destroy($r->folio);

      return ['mensaje' => 'Cotización elminada'];
    }
}	