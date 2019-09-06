<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Jorge prueba</title>

  <style type="text/css">
    @page{
      margin: 0px;
    }
    body{
      margin: 0px;
      font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
    }
    div{
      width: 100%;
    }
    #primer_apartado{
      background-color: blue;
      padding: 12px;
    }
    #header{
      width: 100%;
    }
    .texto_uno{
      font-size: 14px;
      color: white;
      font-weight: bold;
    }
    #uno_fila1{
      align-items: center;
    }
    #fecha{
      background-color: white;
      font-style: cursive;
      font-size: 11px;
    }
    #izquierda{
      text-align: left;
    }
    #derecha{
      text-align: right;
    }
    #centro{
      text-align: center;
    }
    .texto_dos{
      font-size: 13px;
    }
    .texto_tres{
      color: white;
      font-size: 13px;
    }
    .texto_cuatro{
      color: black;
      font-size: 13px;
      padding-left: 10px;
    }
  </style>
</head>
<body style="margin-left: 10px; margin-right: 10px; margin-top: 3px;">
  @php
    $ingresos = round($coti->presupuesto_viajes * $coti->flete, 2);
  @endphp
  <div>
    <img src="img/pdf_header.jpg" id="header">
  </div>
  <div style="background-color: blue; padding: 10px">
    <table class="table table-hover" style="width: 100%">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td colspan="3" class="texto_uno" id="izquierda">Cliente</label></td>
          <td colspan="3" class="texto_uno" id="centro">{{$coti->cliente->nombre}}</td>
          <td colspan="3" class="texto_uno" id="derecha">Folio-{{$coti->folio}}</td>
        </tr>
        <tr>
          <td colspan="3" class="texto_uno" id="izquierda">Origen</label></td>
          <td colspan="3" class="texto_uno" id="centro">{{$coti->ruta->ciudad_origen->nombre}}, {{$coti->ruta->ciudad_origen->estado->nombre}}</td>
          <td colspan="3" class="texto_uno" id="derecha">{{$coti->fecha}}</td>
        </tr>
        <tr>
          <td colspan="3" class="texto_uno" id="izquierda">Destino</label></td>
          <td colspan="3" class="texto_uno" id="centro">{{$coti->ruta->ciudad_destino->nombre}}, {{$coti->ruta->ciudad_destino->estado->nombre}}</td>
          <td colspan="3" class="texto_uno" id="derecha">Flete:</td>
        </tr>
        <tr>
          <td colspan="3" class="texto_uno" id="izquierda">Configuración</label></td>
          <td colspan="3" class="texto_uno" id="centro">{{$coti->camion->tipo_configuracion->configuracion}}</td>
          <td colspan="3" class="texto_uno" id="derecha" style="font-size: 30px;">${{number_format($coti->flete, 2, '.', ',')}}</td>
        </tr>
        <tr>
          <td colspan="3" class="texto_uno" id="izquierda">Tipo/Kilometros</label></td>
          <td colspan="3" class="texto_uno" id="centro">{{$coti->tipo}}</td>
          <td colspan="3" class="texto_uno" id="derecha">{{$coti->total_kilometros}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <table style="width: 100%">
    <thead>
    </thead>
    <tbody>
      <tr style="width: 100%;">
        <td colspan="2" id="izquierda" style="width: 100%">
          <table style="width: 100%">
            <thead>
            </thead>
            <tbody>
              @if ($coti->precio_km > 0)
                <tr>
                  <th colspan="2" class="texto_dos">Precio por kilometro</th>
                  <th colspan="2"><label><i class="texto_dos">${{number_format($coti->precio_km, 2, '.', ',')}}</i></label></th>
                </tr>
              @endif
              <tr>
                <th colspan="2" class="texto_dos">Costo litro de diesel</th>
                <th colspan="2"><label><i class="texto_dos">${{number_format($coti->litro_diesel, 2, '.', ',')}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_dos">Kilometros en un sentido</th>
                <th colspan="2"><label><i class="texto_dos">{{$coti->kilometros_ida}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_dos">Autopistas en un sentido</th>
                <th colspan="2"><label><i class="texto_dos">${{number_format($coti->costo_pista, 2, '.', ',')}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_dos">Rendimiento de diesel</th>
                <th colspan="2"><label><i class="texto_dos">{{$coti->rendimiento_diesel}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_dos">Presupuesto de viajes mensuales</th>
                <th colspan="2"><label><i class="texto_dos">{{$coti->presupuesto_viajes}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_dos">Sueldo de operador por kilometro</th>
                <th colspan="2"><label><i class="texto_dos">${{number_format($coti->sueldo_kilometro, 2, '.', ',')}}</i></label></th>
              </tr>
            </tbody>
          </table>
        </td>
        <td colspan="2" id="derecha" style="width: 100%">
          <table style="background-color: grey; width: 100%">
            <thead>
            </thead>
            <tbody>
              <tr>
                <th colspan="2" class="texto_tres">Ingresos por flete</th>
                <th colspan="2"><label><i class="texto_tres">${{number_format($coti->flete, 2, '.', ',')}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_tres">Costo por viaje</th>
                <th colspan="2"><label><i class="texto_tres">${{number_format($coti->costo_viaje, 2, '.', ',')}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_tres">Utilidad por viaje</th>
                <th colspan="2"><label><i class="texto_tres">${{number_format($coti->utilidad_viaje, 2, '.', ',')}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_tres">Total kilometros mensuales</th>
                <th colspan="2"><label><i class="texto_tres">{{$coti->tkm_mensual}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_tres">Litros diesel por viaje</th>
                <th colspan="2"><label><i class="texto_tres">{{$coti->litros_diesel}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_tres">Venta por kilometro</th>
                <th colspan="2"><label><i class="texto_tres">${{number_format($coti->venta_kilometro, 2, '.', ',')}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_tres">Costo por kilometro</th>
                <th colspan="2"><label><i class="texto_tres">${{number_format($coti->costo_kilometro, 2, '.', ',')}}</i></label></th>
              </tr>
              <tr>
                <th colspan="2" class="texto_tres">Utilidad por kilometro</th>
                <th colspan="2"><label><i class="texto_tres">${{number_format($coti->utilidad_kilometro, 2, '.', ',')}}</i></label></th>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <table style="background-color: white; width: 100%">
    <thead>
      <tr>
        <th style="background-color: grey; width: 100%; font-size: 20px" id="centro" colspan="9">Modelo economico mensual</th>
      </tr>
    </thead>
    <tbody>
      <tr style="background-color: #ffa200;">
        <th colspan="3" class="texto_cuatro" style="font-size: 17px;">Ingresos del viaje</th>
        <th colspan="2"></th>
        <th colspan="2"></th>
        <th colspan="2"><label><i class="texto_cuatro" style="font-size: 17px;">${{number_format($ingresos, 2, '.', ',')}}</i></label></th>
      </tr>
      <tr style="background-color: #ffa200">
        <th colspan="3" class="texto_cuatro"><strong>Costo variable de operación</strong></th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cvo->costo, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->costo/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->costo/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Diesel</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cvo->total_costo_diesel, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->total_costo_diesel/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->total_costo_diesel/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Autopistas</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cvo->costo_autopistas, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->costo_autopistas/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->costo_autopistas/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Sueldo</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cvo->sueldo, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->sueldo/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->sueldo/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Otros</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cvo->otros, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->otros/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvo->otros/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr style="background-color: #ffa200;">
        <th colspan="3" class="texto_cuatro">Costo variable de mantenimiento</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cvm->costo, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvm->costo/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvm->costo/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Refacciones y M.O.</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cvm->refaccion_MO, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvm->refaccion_MO/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvm->refaccion_MO/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Llantas</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cvm->llantas, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvm->llantas/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cvm->llantas/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr style="background-color: #ffa200;">
        <th colspan="3" class="texto_cuatro">Incidencias operativas</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->io->costo, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->io->costo/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->io->costo/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Deducibles y otros</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->io->deducibles_otros, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->io->deducibles_otros/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->io->deducibles_otros/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr style="background-color: #ffa200;">
        <th colspan="3" class="texto_cuatro">Costo fijo de operación</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cfo->costo, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->costo/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->costo/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Arrendamientos</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cfo->arrendamientos, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->arrendamientos/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->arrendamientos/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Seguros</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cfo->seguros, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->seguros/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->seguros/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Carga social</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cfo->carga_social, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->carga_social/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->carga_social/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Otros</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cfo->otros, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->otros/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfo->otros/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr style="background-color: #ffa200;">
        <th colspan="3" class="texto_cuatro">Costo fijo de administración</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cfa->costo, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfa->costo/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfa->costo/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Sueldos y salarios</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cfa->sueldos, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfa->sueldos/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfa->sueldos/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Otros</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cfa->otros, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfa->otros/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cfa->otros/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr style="background-color: #ffa200;">
        <th colspan="3" class="texto_cuatro">Costo integral del financiamiento</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cf->costo, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cf->costo/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cf->costo/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr>
        <th colspan="3" class="texto_cuatro">Intereses</th>
        <th colspan="2"><label><i class="texto_cuatro">${{number_format($coti->cf->intereses, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cf->intereses/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro">{{round($coti->cf->intereses/$coti->tkm_mensual, 2, PHP_ROUND_HALF_UP)}}</i></label></th>
      </tr>
      <tr style="background-color: #ffa200">
        <th colspan="3" class="texto_cuatro" style="font-size: 20px">Utilidad de operación</th>
        <th colspan="2"><label><i class="texto_cuatro"></i></label></th>
        <th colspan="2"><label><i class="texto_cuatro" style="font-size: 20px">${{number_format($coti->utilidad_operativa, 2, '.', ',')}}</i></label></th>
        <th colspan="2"><label><i class="texto_cuatro" style="font-size: 20px">{{round($coti->utilidad_operativa/$ingresos*100, 2, PHP_ROUND_HALF_UP)}}%</i></label></th>
      </tr>
      <tr>
        <th colspan="5"></th>
        @if($coti->estado == "Aceptable")
          <th colspan="4" style="text-align: center; background-color: green;"><label class="texto_uno" style="font-size: 23px;">Aceptable</label></th>
        @else
          <th colspan="4" style="text-align: center; background-color: red;"><label class="texto_uno" style="font-size: 23px;">En revision</label></th>
        @endif
      </tr>
      <tr>
        <td colspan="3">
          <div style="border-style: groove; height: 125px; align-items: center;"> 
            <div style="height: 35px; margin-top: 80px; border-top-style: dashed;">
              <label style="font-size: 13px;">{{$nombres['logistica']}}</label>
              <br>
              <label><strong>Gcia. Admon. Ope. Logisticas</strong></label>
            </div>
          </div>
        </td>
        <td colspan="3">
          <div style="border-style: groove; height: 125px;">
            <div style="height: 35px; margin-top: 80px; border-top-style: dashed;">
              <label style="font-size: 13px;">{{$nombres['general']}}</label>
              <br>
              <label><strong>Gerencia general</strong></label>
            </div>
          </div>
        </td>
        <td colspan="3">
          <div style="border-style: groove; height: 125px;">
            <div style="height: 35px; margin-top: 80px; border-top-style: dashed;">
              <label style="font-size: 13px;">{{$nombres['transportes']}}</label>
              <br>
              <label><strong>Gerencia de transporte</strong></label>
            </div>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>
