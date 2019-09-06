@extends('vistas.base')

@section('css')
  <style type="text/css">
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 16px;
      width: 16px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #EC6610;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }

    .fa-plus-circle{
      cursor: pointer;
      color: green;
    }
    .etiquetas{
      font-size: 12px;
    }
    .estado_agregar{
      font-size: 12px;
    }

    table {
      font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
      margin-right: 5px;
        font-size: 10px;    
        width: 480px; 
        text-align: left;    
        border-collapse: collapse; 
    }

    th {  
      font-size: 10px;
      padding-left: 2px;
      font-weight: normal;     
      background: #ffff42;
        border-bottom: 1px solid #fff; 
        color: #039; 
    }

    td {    
      background: white;
      padding-left: 2px;    
      border-bottom: 1px solid #fff;
        color: #669;    
        border-top: 1px solid transparent; 
    }

    tr:hover td { 
      background: #d0dafd; 
      color: #339; 
    }

    input.input-table{
      background-color: #ffff99; 
      border-color: #039; 
      color: #039; 
      border: 0; 
      text-align: center; 
      width: 90px;
      font-size: 10px;
    }
    .tipos_añadir{
      align-items: center;
      display: flex;
      justify-content: center;
    }

    input.input-td{
      border-color: #039; 
      color: #039; 
      border: 0; 
      text-align: center; 
      width: 90px;
      font-size: 10px;
    }

    .box {
    width: 300px;
    margin: 25px 0;
    display: flex;
    align-items: center;
    user-select: none;
  }

   #labelcheck{
      font-size: 14px;
      color: #4D4D4D;
      position: absolute;
      z-index: 10;
      padding-left: 30px;
      cursor: pointer;
    }

    .incheck{
      opacity: 0;
      visibility: hidden;
      position: absolute;
    }
    .incheck:checked + .check{
      border-color: #428BCA;
      box-shadow: 0px 0px 0px 15px #428BCA inset;
    }

    .incheck:after{
      opacity: 1;
      transform: scale(1);
    }

    .check {
        width: 20px;
        height: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        border-radius: 100px;
        background-color: #FFF;
        border: 2px solid #428BCA;
        box-shadow: 0px 0px 0px 0px #00EA90 inset;
        transition: all 0.15s cubic-bezier(0, 1.05, 0.72, 1.07);
      }
  </style>

  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('contenido')
<meta name="csrf-token" content="{{ csrf_token() }}">

  <form method="GET" action="{{url('/RegistrarCoti')}}">
    @csrf
    <div class="row">
      <div class="col-lg-7">
        <div class="card shadow mb-4">
          <!-- Card Header - Accordion -->
          <a href="#coti-collapse" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="coti-collapse">
            <h6 class="m-0 font-weight-bold text-primary">Información de cotización</h6>
          </a>
          <!-- Card Content - Collapse -->
          <div class="collapse show" id="coti-collapse">
            <div class="card-body">
              <div class="form-group form-inline">
                <div class="form-group form-inline col-sm-4">
                  <label class="etiquetas" for="clientes">Clientes:</label>
                  &nbsp;
                  <select style="font-size: 10px;" name="cliente" id="clientes" class="form-control form-control-sm" required="required" onchange="CalcularIngreso()">
                    @foreach($datos['clientes'] as $cliente)
                      <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                    @endforeach
                  </select>
                  &nbsp;
                  <i class="fas fa-plus-circle fa-lg" id="cliente_add" onclick="LanzarModal($(this))" title="Agregar un nuevo cliente"></i>
                </div>
                <div class="form-group form-inline col-sm-4" style="margin-top: 10px;">
                  <label class="etiquetas" for="select_config">Configuración:</label>
                  &nbsp;
                  <select style="font-size: 10px;" name="configuracion" id="select_config" class="form-control form-control-sm" onchange="CalcularSueldoXKm()">
                    @foreach($datos['configuraciones'] as $config)
                      <option value="{{$config->id}}">{{$config->configuracion}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group form-inline col-sm-4" style="margin-top: 10px;">
                  <label class="etiquetas" for="select_tipo">Tipo:</label>
                  &nbsp;
                  <select style="font-size: 10px;" name="tipo" id="select_tipo" class="form-control form-control-sm" onchange="CalcularRedondo()">
                    <option value="1">Un sentido</option>
                    <option value="2">Doble sentido</option>
                  </select>
                </div>
              </div>
              <div class="form-group form-inline">
                <div class="form-group">
                  <div class="form-group col-sm-12">
                    <label class="etiquetas">Origen:</label>
                    &nbsp;
                    <div class="form-group form-inline">
                      <select style="font-size: 10px;" name="estado_origen" id="estado_origen" class="form-control form-control-sm" onchange="CargarCiudades($(this), 'origen')">
                        <option selected="true" disabled="disabled">- Elije una opción -</option>
                        @foreach($datos['estados'] as $estado)
                          <option value="{{$estado}}">{{$estado->nombre}}</option>
                        @endforeach
                      </select>
                      <select style="font-size: 10px;" name="ciudad_origen" id="ciudad_origen" class="form-control form-control-sm" required="required">
                      </select>
                      &nbsp;
                      <i class="fas fa-plus-circle fa-lg" id="ciudad_add" onclick="LanzarModal($(this))" title="Agregar una nueva ciudad"></i>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-group col-sm-12">
                    <label class="etiquetas">Destino:</label>
                    &nbsp;
                    <div class="form-group form-inline">
                      <select style="font-size: 10px;" name="estado_destino" id="estado_destino" class="form-control form-control-sm" onchange="CargarCiudades($(this), 'destino')">
                        <option selected="true" disabled="disabled">- Elije una opción -</option>
                        @foreach($datos['estados'] as $estado)
                          <option value="{{$estado}}">{{$estado->nombre}}</option>
                        @endforeach
                      </select>
                      <select style="font-size: 10px;" name="ciudad_destino" id="ciudad_destino" class="form-control form-control-sm" required="required">
                      </select>
                      &nbsp;
                      <i class="fas fa-plus-circle fa-lg" id="ciudad_add" onclick="LanzarModal($(this))" title="Agregar una nueva ciudad"></i>
                    </div>
                  </div>
                </div>  
              </div>
              <hr>
                <div class="form-group form-inline">
                  <div class="col-sm-4 form-inline" hidden="hidden">
                    <label class="etiquetas" for="mesactual">
                      litro_diesel:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="litro_diesel" id="litro_diesel" class="form-control form-control-sm" value="" title="" step="any">
                  </div>
                  <div class="col-sm-4 form-inline">
                    <label class="etiquetas" for="mesactual">
                      Flete:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="flete" id="flete" class="form-control form-control-sm" value="" title="" onkeyup="CalcularIngreso()" step="any">
                  </div>
                  <div class="col-sm-4 form-inline">
                    <label class="etiquetas" for="mesactual">
                      Pistas en un sentido:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="un_sentido" id="un_sentido" class="form-control form-control-sm" value="" required="required" 
                    onkeyup="if (data['resumen'] != undefined) {MostrarResumen(); }" step="any">
                  </div>
                  <div class="form-group form-inline col-sm-4">
                    <label class="etiquetas" for="mesactual">
                      Rendimiento:
                    </label>&nbsp;
                    <input step="any" style="font-size: 10px;" type="number" name="rendimiento" id="rendimiento" class="form-control form-control-sm" value="" required="required" title="" onkeyup="CalcularLitrosDiesel()" step="any">
                  </div>
                  <div class="col-sm-4 form-inline">
                    <label class="etiquetas" for="mesactual">
                      Presupuesto de viajes mensuales:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="presupuesto" id="presupuesto" class="form-control form-control-sm" value="" required="required" title="" onkeyup="CalcularIngreso()" step="any">
                  </div>
                  <div class="col-sm-4 form-inline">
                    <label class="etiquetas" for="mesactual">
                      Kilometros en un sentido:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="km_uno" id="km_uno" class="form-control form-control-sm" value="" required="required" title="" onkeyup="CalcularRedondo()" step="any">
                  </div>
                  <div class="col-sm-4 form-inline" id="mostrarprecio" hidden="hidden">
                    <label class="etiquetas" for="mesactual" style="color: blue;">
                      Precio por kilometro
                    </label>&nbsp;
                    <input style="font-size: 10px; border-color: blue; color: blue;" type="number" name="precio_km" id="precio_km" class="form-control form-control-sm" value="0" required="required" title="" onkeyup="CalcularIngreso()" step="any">
                  </div>
                  <div class="col-sm-4 form-inline">
                    <label class="etiquetas" for="mesactual" style="color: green;">
                      Flete sugerido:
                    </label>&nbsp;
                    <input style="font-size: 10px; border-color: green; color: green; margin-right: 5px;" type="number" class="form-control form-control-sm" disabled="disabled" value="0" step="any" id="sugerido">
                    <a class="btn btn-icon-split btn-sm" title="Usar sugerencia" style="cursor: pointer; background-color: green;" onclick="CambiarFlete()">
                      <span class="icon text-white-50">
                        <i class="fas fa-exchange-alt"style="color: white;"></i>
                      </span>
                    </a>
                  </div>
                </div>
                <hr>


                <div class="form-group form-inline">
                  <div class="form-group form-inline col-sm-4">
                    <label class="etiquetas" for="mesactual">
                      Kilometros redondos:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="km_redondo" id="km_redondo" class="form-control form-control-sm" value="" required="required" step="any">
                  </div>
                  <div class="form-group form-inline col-sm-4">
                    <label class="etiquetas" for="mesactual">
                      Sueldo de operador por km:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="sueldo_km" id="sueldo_km" class="form-control form-control-sm" value="" required="required" title="" step="any" onkeyup="MostrarResumen()">
                  </div>
                  <div class="col-sm-4 form-inline">
                    <label class="etiquetas" for="mesactual">
                      Costo por viaje:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="costo_viaje" id="costo_viaje" class="form-control form-control-sm" value="" required="required" title="" onchange="CalcularUtilidad()" step="any">
                  </div>
                  <div class="form-group form-inline col-sm-4">
                    <label class="etiquetas" for="mesactual">
                      Utilidad por viaje:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="utilidad" id="utilidad" class="form-control form-control-sm" value="" required="required" title="" step="any">
                  </div>
                  <div class="col-sm-4 form-inline">
                    <label class="etiquetas" for="mesactual">
                      Kilometros mensuales:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="km_mensuales" id="km_mensuales" class="form-control form-control-sm" value="" required="required" step="any" onkeyup="CalcularKmMensuales()">
                  </div>
                  <div class="form-group form-inline col-sm-4">
                    <label class="etiquetas" for="mesactual">
                      Litros de diesel por viaje:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="litros_diesel" id="litros_diesel" class="form-control form-control-sm" value="" required="required" title="" step="any">
                  </div>
                  <div class="col-sm-4 form-inline">
                    <label class="etiquetas" for="mesactual">
                      Venta por kilometro:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="venta_km" id="venta_km" class="form-control form-control-sm" value="" required="required" title="" step="any">
                  </div>
                  <div class="form-group form-inline col-sm-4">
                    <label class="etiquetas" for="mesactual">
                      Costo por kilometro:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="costo_kilometro" id="costo_kilometro" class="form-control form-control-sm" value="" required="required" title="" step="any">
                  </div>
                  <div class="form-group form-inline col-sm-4">
                    <label class="etiquetas" for="mesactual">
                      Utilidad por kilometro:
                    </label>&nbsp;
                    <input style="font-size: 10px;" type="number" name="utilidad_kilometro" id="utilidad_kilometro" class="form-control form-control-sm" value="" required="required" title="" step="any">
                  </div>
                </div>
                <hr>
                <div class="form-inline col-sm-12">
                  <button type="submit" class="btn btn-success btn-icon-split" style="margin-right: 10px">
                    <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                    </span>
                    <span class="text">Registrar</span>
                  </button>
                  <a href="{{url('/FormCotizar')}}" class="btn btn-danger btn-icon-split" data-dismiss="modal">
                    <span class="icon text-white-50">
                      <i class="fas fa-trash"></i>
                    </span>
                    <span class="text">Limpiar</span>
                  </a>
                  <div style="padding-left: 30px;">
                    <div class="alert alert-success animated bounceInup" role="alert" id="alert_ganancia" hidden="true">
                      <i class="fas fa-check-circle"></i> 
                      <strong>La ganancia es aceptable <i>(<strong id="ganancia">+1.0</strong>%)</i></strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#Resumen-collapse" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="Resumen-collapse">
              <h6 class="m-0 font-weight-bold text-primary">Modelo ecónomico mensual</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse show" id="Resumen-collapse">
              <div class="card-body row">
                <div class="col-sm-12 form-inline">
                  <div class="form-inline col-sm-6">
                    <a data-toggle="modal" id="cargar_Resumen" href="" class="btn btn-primary btn-icon-split form-control-sm" style="margin-bottom: 10px" onclick="LanzarModal($(this))">
                      <span class="icon text-white-50">
                        <i class="fas fa-plus" style="color: white"></i>
                      </span>
                      <span class="text">Cargar datos</span>
                    </a>
                  </div>
                  <div class="input-group col-sm-6">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1" style="height: 31px">%</span>
                    </div>
                    <input type="number" step="any" class="form-control form-control-sm" placeholder="Porcentaje minimo" aria-label="Username" aria-describedby="basic-addon1" style="text-align: center;" id="porcentaje_minimo" onkeyup="CalcularGanancia()">
                  </div>
                </div>
                <div class="col-sm-12">
                  <table class="col-sm-12">
                    <thead>
                    </thead>
                    <tbody>
                      <tr>
                        <th colspan="4" style="font-size: 20px">Ingresos del viaje</th>
                        <th colspan="2"><input type="number" step="any" name="ingresos_viaje" id="ingresos_viaje" class="form-control form-control-sm input-table" style="font-size: 15px; width: 180px" onkeyup="CalcularPorcentajes()"></th>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm-6">
                  <table class="col-sm-12 cvo_resumen">
                    <thead>
                    </thead>
                    <tbody>
                      <tr>
                        <th colspan="2" style="font-size: 12px;">Costo variable de operación</th>
                        <th colspan="2"><input type="number" step="any" name="cvo_total" id="cvo_total" class="form-control form-control-sm input-table"></th>
                        <th colspan="2"><label><i id="cvo_porcentaje">0%</i></label></th>
                      </tr>
                      <tr>
                        <td colspan="3">Diesel</td>
                        <td colspan="3"><input type="number" step="any" name="diesel" id="diesel" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <td colspan="3">Autopistas</td>
                        <td colspan="3"><input type="number" step="any" name="autopistas" id="autopistas" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <td colspan="3">Sueldo</td>
                        <td colspan="3"><input type="number" step="any" name="sueldo" id="sueldo" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <td colspan="3">Otros</td>
                        <td colspan="3"><input type="number" step="any" name="cvo_otros" id="cvo_otros" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <th colspan="2" style="font-size: 12px;">Costo fijo de operación</th>
                        <th colspan="2"><input type="number" step="any" name="cfo_total" id="cfo_total" class="form-control form-control-sm input-table"></th>
                        <th colspan="2"><label><i id="cfo_porcentaje">0%</i></label></th>
                      </tr>
                      <tr>
                        <td colspan="3">Arrendamientos</td>
                        <td colspan="3"><input type="number" step="any" name="arrendamientos" id="arrendamientos" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <td colspan="3">Seguros</td>
                        <td colspan="3"><input type="number" step="any" name="seguros" id="seguros" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <td colspan="3">Carga social</td>
                        <td colspan="3"><input type="number" step="any" name="carga_social" id="carga_social" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <td colspan="3">Otros</td>
                        <td colspan="3"><input type="number" step="any" name="cfo_otros" id="cfo_otros" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm-6">
                  <table class="col-sm-12">
                    <thead>
                    </thead>
                    <tbody>
                      <tr>
                        <th colspan="2" style="font-size: 12px;">Costo variable de mantenimiento</th>
                        <th colspan="2"><input type="number" step="any" name="cvm_total" id="cvm_total" class="form-control form-control-sm input-table"></th>
                        <th colspan="2"><label><i id="cvm_porcentaje">0%</i></label></th>
                      </tr>
                      <tr>
                        <td colspan="3">Refacciones y MO</td>
                        <td colspan="3"><input type="number" step="any" name="refaccion_mo" id="refaccion_mo" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <td colspan="3">Llantas</td>
                        <td colspan="3"><input type="number" step="any" name="llantas" id="llantas" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <th colspan="2" style="font-size: 12px;">Incidencias operativas</th>
                        <th colspan="2"><input type="number" step="any" name="io_total" id="io_total" class="form-control form-control-sm input-table"></th>
                        <th colspan="2"><label><i id="io_porcentaje">0%</i></label></th>
                      </tr>
                      <tr>
                        <td colspan="3">Deducibles y otros</td>
                        <td colspan="3"><input type="number" step="any" name="deducibles_otros" id="deducibles_otros" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <th colspan="2" style="font-size: 12px;">Costo fijo de administración</th>
                        <th colspan="2"><input type="number" step="any" name="cfa_total" id="cfa_total" class="form-control form-control-sm input-table"></th>
                        <th colspan="2"><label><i id="cfa_porcentaje">0%</i></label></th>
                      </tr>
                      <tr>
                        <td colspan="3">Sueldos y salarios</td>
                        <td colspan="3"><input type="number" step="any" name="sueldos_salarios" id="sueldos_salarios" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <td colspan="3">Otros</td>
                        <td colspan="3"><input type="number" step="any" name="cfa_otros" id="cfa_otros" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                      <tr>
                        <th colspan="2" style="font-size: 12px;">Costo integral financiero</th>
                        <th colspan="2"><input type="number" step="any" name="cif_total" id="cif_total" class="form-control form-control-sm input-table"></th>
                        <th colspan="2"><label><i id="cif_porcentaje">0%</i></label></th>
                      </tr>
                      <tr>
                        <td colspan="3">Intereses</td>
                        <td colspan="3"><input type="number" step="any" name="intereses" id="intereses" class="form-control form-control-sm input-td" onkeyup="CalcularTotalesResumen()"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-sm-12">
                  <table class="col-sm-12">
                    <thead>
                    </thead>
                    <tbody>
                      <tr>
                        <th colspan="6" style="font-size: 17px">Utilidad de operación</th>
                        <th colspan="3"><input type="number" step="any" name="utilidad_operacion" id="utilidad_operacion" class="form-control form-control-sm input-table" style="font-size: 15px; width: 130px" value=""></th>
                        <th colspan="3"><label ><i id="utilidad_porcentaje" style="font-size: 15px;">0%</i></label></th>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </form>

  <form method="POST" role="form" id="modal_form" onsubmit="ConectarServidor(); return false;">
    @csrf
    <!-- The Modal -->
    <div class="modal fade" id="modal_añadir">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" id="titulo_modal">Seleccionar tipo de resumen</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div id="contenido_modal">
              
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-icon-split" id="boton_cambiar" >
              <span class="icon text-white-50">
                <i class="fas fa-check"></i>
              </span>
              <span class="text" id="texto_boton">Agregar</span>
            </button>
            <a href="#" class="btn btn-danger btn-icon-split" data-dismiss="modal">
              <span class="icon text-white-50">
                <i class="fas fa-trash"></i>
              </span>
              <span class="text">Cancelar</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection


@section('javascript')
  <script type="text/javascript">
    var data = [];
    $(document).ready(function() {
      CalcularSueldoXKm();
      if ($('#ingresos_viaje').val()) {
        CalcularPorcentajes();
      }
      if ($('#cvo_total').val()) {
        CalcularCostoXViaje();
      }
      if($('#clientes').val() == 1){
        CalcularExcepcion();
      } 
    });

    function CalcularPorcentajes(){
      var ingresos = $('#ingresos_viaje').val();
      if ($('#cvo_total').val() && $('#ingresos_viaje').val()) {
        $('#cvo_porcentaje').text(Math.ceil(($('#cvo_total').val()/ingresos*100)*100)/100+'%');
        $('#cfo_porcentaje').text(Math.ceil(($('#cfo_total').val()/ingresos*100)*100)/100+'%');
        $('#cvm_porcentaje').text(Math.ceil(($('#cvm_total').val()/ingresos*100)*100)/100+'%');
        $('#cfa_porcentaje').text(Math.ceil(($('#cfa_total').val()/ingresos*100)*100)/100+'%');
        $('#cif_porcentaje').text(Math.ceil($('#cif_total').val()/ingresos*100)+'%');
        $('#io_porcentaje').text(Math.ceil(($('#io_total').val()/ingresos*100)*100)/100+'%');

        $('#utilidad_operacion').val(Math.ceil(($('#ingresos_viaje').val()-$('#cvo_total').val()-$('#cfo_total').val()-$('#cvm_total').val()-$('#cfa_total').val()-$('#cif_total').val()-$('#io_total').val())*100)/100);
        $('#utilidad_porcentaje').text(Math.ceil(($('#utilidad_operacion').val()/ingresos*100)*100)/100+'%');
      }
      else {
        $('#cvo_porcentaje').text('0%');
        $('#cfo_porcentaje').text('0%');
        $('#cvm_porcentaje').text('0%');
        $('#cfa_porcentaje').text('0%');
        $('#cif_porcentaje').text('0%');
        $('#io_porcentaje').text('0%');

        $('#utilidad_operacion').val(0.00);
        $('#utilidad_porcentaje').text('0%');
      }

      CalcularGanancia();
    }

    function CargarCiudades(estado, punto)
    {
      console.log($('#estado_origen').val());
      var ciudades = JSON.parse(estado.val()).ciudades;
      console.log(ciudades);

      if (punto == 'origen') {
        $('#ciudad_origen').empty();
        ciudades.forEach((item) => {
          $('#ciudad_origen').append('<option value="'+item.id+'">'+item.nombre+'</option>');
        });
      }
      else {
        $('#ciudad_destino').empty();
        ciudades.forEach((item) => {
          $('#ciudad_destino').append('<option value="'+item.id+'">'+item.nombre+'</option>');
        });
      }
    }

    function LanzarModal(elemento)
    {
      $('#contenido_modal').empty();
      var titulo = $('#titulo_modal');
      titulo.empty();

      if (elemento.attr('id') == 'cargar_Resumen') {
        $('#texto_boton').text('Cargar');
      }
      else {
        $('#texto_boton').text('Agregar');
      }

      switch (elemento.attr('id')) {
        case 'cliente_add':
          $('#boton_cambiar').addClass('btn-success');
          $('#boton_cambiar').removeClass('btn-primary');

          $('#boton_cambiar i').addClass('fa-check');
          $('#boton_cambiar i').removeClass('fa-cog');

          $('#contenido_modal').append('<div class="tipos_añadir"><img src="img/cliente_add.jpg" class="" style="width: 200px" align="center"> <div class="offset-1"> <label>Nombre del nuevo cliente: </label> <input type="text" name="cliente" id="input" class="form-control form-control-sm" value="" spattern="" title="" autofocus="true"required="required"> </div></div>');
          titulo.append('Añadir cliente');
          $('#modal_añadir').modal('show');
          $('#modal_form').attr('action', "{{url('/AgregarCliente')}}");
          break;
        case 'ciudad_add':
          $('#boton_cambiar').addClass('btn-success');
          $('#boton_cambiar').removeClass('btn-primary');

          $('#boton_cambiar i').addClass('fa-check');
          $('#boton_cambiar i').removeClass('fa-cog');

          $('#contenido_modal').append('<div class="tipos_añadir"><img src="img/destino_add.png" class="" style="width: 200px" align="center"><div class="offset-1"><label>Estado: </label>&nbsp;&nbsp;&nbsp;<label class="switch"><input type="hidden" name="radio_estado" value="0"><input type="checkbox" onclick="CambiarEstado($(this))" id="radio_estado" name="radio_estado" value="1"><span class="slider round"></span></label>&nbsp;<label><i id="estado" class="estado_agregar">(Existente)</i></label><div id="contenedor_input"><select name="estado" id="nuevo_estado" class="form-control form-control-sm" required="required">@foreach($datos["estados"] as $estado)<option value="{{$estado->id}}">{{$estado->nombre}}</option>@endforeach</select></div><br><label>Ciudad: </label><input type="text" name="ciudad" id="input" class="form-control form-control-sm" value="" autofocus="true" required="required"><br><label>Descripción: </label><label><i id="descripcion" class="estado_agregar">(Opcional)</i></label><textarea name="" id="input" class="form-control" rows="2"></textarea></div></div>');
          titulo.append('Añadir ciudad');
          $('#modal_añadir').modal('show');
          $('#modal_form').attr('action', "{{url('/AgregarCiudad')}}");
          break;
        case 'config_add':
          $('#boton_cambiar').addClass('btn-success');
          $('#boton_cambiar').removeClass('btn-primary');

          $('#boton_cambiar i').addClass('fa-check');
          $('#boton_cambiar i').removeClass('fa-cog');

          $('#contenido_modal').append('<div class="tipos_añadir"><img src="img/conf_add.png" class="" style="width: 200px" align="center"> <div class="offset-1"> <label>Nuevo tipo de configuración: </label> <input type="text" name="config" id="input" class="form-control form-control-sm" value="" autofocus="true" required="required"> </div></div>');
          titulo.append('Añadir configuración');
          $('#modal_añadir').modal('show');
          $('#modal_form').attr('action', "{{url('/AgregarConfiguracion')}}");
          break;
        case 'cargar_Resumen':
          $('#boton_cambiar').removeClass('btn-success');
          $('#boton_cambiar').addClass('btn-primary');

          $('#boton_cambiar i').removeClass('fa-check');
          $('#boton_cambiar i').addClass('fa-cog');

          $('#contenido_modal').append('<div class="form-group"> <h6 for="input" class="col-sm-12 control-label">Selecciona el tipo de resumen</h6> <div> <select name="tipo_resumen" id="tipo_seleccion" class="form-control" required="required" onchange="LlenarSeleccion($(this))"> <option selected="true" disabled="disabled">--- Elije una opción ---</option> <option value="mensual">Mensual</option> <option value="anual">Anual</option> <option value="promedio">Promedio</option> <option value="acumulado">Acumulado</option> </select> </div> </div><div id="contenido_seleccion"></div>');
          titulo.append('Resumen');
          $('#modal_añadir').modal('show');
          $('#modal_form').attr('action', "{{url('/SacarResumen')}}");
          break;
      }
    }

    function CambiarEstado(elemento){
      $('#contenedor_input').empty();

      if ($('#estado').text() == '(Existente)') {
        $('#contenedor_input').append('<input type="text" name="nuevo_estado" id="input_estados" class="form-control form-control-sm" value="" required="required" autofocus="true">');
        $('#estado').text('(Nuevo)');
      }
      else {
        $('#contenedor_input').append('<select name="estado" id="nuevo_estado" class="form-control form-control-sm">@foreach($datos["estados"] as $estado)<option value="{{$estado->id}}">{{$estado->nombre}}</option>@endforeach</select>');
        $('#estado').text('(Existente)');
      }
    }

    function LlenarSeleccion(elemento){
      $('#contenido_seleccion').empty();
      switch (elemento.val()) {
        case 'mensual':
          CargarMensual();
          break;
        case 'anual':
          CargarAnual();
          break;
        case 'promedio':
          CargarAnual();
          break;
        case 'acumulado':
          CargarAnual();
          break;
      }
    }

    /*--------------------------------Funciones Ajax--------------------------------------------*/

    function CargarMensual()
    {
      $.ajax({
        url: "{{url('/ObtenerMensual')}}",
        type: 'POST',
        dataType: 'json',
        data: {
          _token: "{{ csrf_token() }}",
        },
        success: function(respuesta){
          $('#contenido_seleccion').append('<hr><div> <h6 for="input" class="col-sm-12 control-label">Selecciona mes</h6> <input type="month" name="mes" id="input" class="form-control col-sm-7" value="" required="required" title="" min="'+respuesta['min']+'" max="'+respuesta['max']+'"></div>'); 
        },
        error: function(){
          console.log('algo salio mal');
        }
      });  
    }

    function CargarAnual()
    {
      $.ajax({
        url: "{{url('/ObtenerAños')}}",
        type: 'POST',
        dataType: 'json',
        data: {
          _token: "{{ csrf_token() }}",
        },
        success: function(respuesta){    
          $('#contenido_seleccion').append('<hr><div> <h6 for="anual_in" class="col-sm-12 control-label">Selecciona el año</h6><select name="año" id="anual_in" class="form-control" required="required" onchange="CargarMeses()"> <option value="" disabled="disabled" selected="true">---- Elije una opción ----</option> </select> </div>'); 

          for (var llave in respuesta) {
            $('#anual_in').append('<option value="'+llave+'">'+llave+'</option>');
          }
        },
        error: function(){
          console.log('algo salio mal');
        }
      });  
    }

    function CargarMeses(){
      if ($('#tipo_seleccion').val() != 'anual') {
        $('#contenido_seleccion').append('<div id="contmeses"></div>')
        $('#contmeses').empty();
        $.ajax({
          url: "{{url('/ObtenerMeses')}}",
          type: 'POST',
          dataType: 'json',
          data: {
            _token: "{{ csrf_token() }}",
            año: $('#anual_in').val()
          },
          success: function(respuesta){
            if (!respuesta['mensaje']) {
              $('#contmeses').append('<hr><label>Marcar todas las opciones </label>&nbsp;&nbsp;&nbsp;<label class="switch"><input type="checkbox" onclick="MarcarCasillas($(this))" id="radio_casillas"><span class="slider round"></span></label><div class="form-inline" id="meses_div"></div>'); 
              for (var llave in respuesta) {
                $('#meses_div').append('<div class="box col-sm-3"> <input id="'+llave+'" type="checkbox" class="incheck" value="'+respuesta[llave]+'" name="meses[]"> <span class="check"></span> <label for="'+llave+'" id="labelcheck">'+llave+'</label> </div>');
              }
            }
            else {
              $('#contmeses').append('<h4 class="col-sm-12"><i>'+respuesta['mensaje']+'</i></h4>');
            }
          }, 
          error: function(){
            console.log('algo salio mal');
          }
        });  
      }
    }

    function MarcarCasillas(elemento)
    {
      if (elemento.prop('checked')) {
        $('.box input').each(function(index, el) {
          el.checked = true;
        });
      }
      else {
        $('.box input').each(function(index, el) {
          el.checked = false;
        });
      }
    }

    function ConectarServidor()
    {
      if ($('#modal_form').attr('action') != "{{url('/SacarResumen')}}") {
        $.ajax({
          url: $('#modal_form').attr('action'),
          type: 'POST',
          dataType: 'json',
          data: {
            _token: "{{ csrf_token() }}",
            datos: $('#modal_form').serialize(),
          },
          success: function(response){ 
            $('#modal_añadir').modal('toggle');
            console.log(response);

            if (response['dato'] == 'cliente') {
              if (response['tipo'] == 'registrado') {
                swal({
                  title: 'Exitoso!',
                  text: response['mensaje'],
                  type: "success",
                  position: 'top-end',
                  timer: 1200
                });
                $('#clientes').append('<option value="'+response['cliente'].id+'" selected>'+response['cliente'].nombre+'</option>');
              }
              else {
                swal({
                  title: 'Error!',
                  text: response['mensaje'],
                  type: "error",
                  position: 'top-end',
                  timer: 2500
                });
              }
            }
            else if (response['dato'] == 'ciudad') {
              if (response['tipo'] == 'registrado') {
                swal({
                  title: 'Exitoso!',
                  text: response['mensaje'],
                  type: "success",
                  position: 'top-end',
                  timer: 1500
                });
                location.reload();
              }
              else {
                swal({
                  title: 'Error!',
                  text: response['mensaje'],
                  type: "error",
                  position: 'top-end',
                  timer: 2500
                });
              }
            }
            if(response['ciudad'] != undefined){
              if (response['estado'] != undefined) {
                $('#estado_origen').append('<option value="'+response['estado']+'">'+response['estado'].nombre+'</option>');
              }
              else {
                $('#estado_origen').val(response['ciudad'].estado);
                //location.reload();
              }
            }
          },
          error: function(){
            console.log('algo salio mal');
          }
        });
      }
      else {
        $.ajax({
          url: "{{url('/SacarResumen')}}",
          type: 'POST',
          dataType: 'json',
          data: {
            _token: "{{ csrf_token() }}",
            datos: $('#modal_form').serialize(),
          },
          success: function(response){ 
          console.log(response);  
            data['resumen'] = response;
            MostrarResumen();
            $('#modal_añadir').modal('toggle');
            swal({
              title: "Se cargaron los datos",
              type: "success",
              position: 'top-end',
              timer: 1500
            });
          },
          error: function(){
            swal({
              title: "Algo salió mal",
              type: "danger",
              position: 'top-end',
              timer: 1000
            });
          }
        });
      }
    }

    function MostrarResumen()
    {
      var resumen = data['resumen'];
      console.log(resumen);
      $('#diesel').val(Math.ceil($('#litros_diesel').val()*$('#presupuesto').val()*resumen.precio_diesel));

      $('#autopistas').val(Math.ceil($('#un_sentido').val()*$('#presupuesto').val()*resumen.incremento_casetas*$('#select_tipo').val()*100)/100);

      $('#sueldo').val(Math.ceil($('#km_redondo').val()*$('#sueldo_km').val()*$('#presupuesto').val()*100)/100);
      $('#cvo_otros').val(Math.ceil(resumen.cvo_otros/resumen.unidades_operativas*100)/100);

      $('#refaccion_mo').val(Math.ceil(resumen.refaccion_mo/resumen.unidades_operativas*100)/100);
      $('#llantas').val(Math.ceil(resumen.llantas/resumen.unidades_operativas*100)/100);
      //$('#cvm_total').val($('#refaccion_mo').val()+$('#llantas').val());

      $('#deducibles_otros').val(Math.ceil(resumen.deducibles_otros/resumen.unidades_operativas*100)/100);

      $('#arrendamientos').val(Math.ceil(resumen.arrendamientos/resumen.unidades_pagadas*100)/100);
      $('#seguros').val(Math.ceil(resumen.seguros/resumen.unidades_operativas*100)/100);
      $('#carga_social').val(Math.ceil(resumen.carga_social/resumen.unidades_operativas*100)/100);
      $('#cfo_otros').val(Math.ceil(resumen.cfo_otros/resumen.unidades_operativas*100)/100);

      $('#sueldos_salarios').val(Math.ceil(resumen.sueldos_salarios/resumen.unidades_operativas*100)/100);
      $('#cfa_otros').val(Math.ceil(resumen.cfa_otros/resumen.unidades_operativas*100)/100);

      $('#intereses').val(Math.ceil((resumen.intereses/resumen.unidades_pagadas)*100)/100);

      $('#litro_diesel').val(Math.ceil(resumen.precio_diesel*100)/100);

      CalcularTotalesResumen();
    }

    function CalcularTotalesResumen()
    {
      $('#cvo_total').val(Math.ceil((parseFloat($('#diesel').val())+parseFloat($('#autopistas').val())+parseFloat($('#sueldo').val())+parseFloat($('#cvo_otros').val()))*100)/100);
      $('#cvm_total').val(Math.ceil((parseFloat($('#refaccion_mo').val())+parseFloat($('#llantas').val()))*100)/100);
      $('#io_total').val(Math.ceil(($('#deducibles_otros').val())*100)/100);
      $('#cfo_total').val(Math.ceil((parseFloat($('#arrendamientos').val())+parseFloat($('#seguros').val())+parseFloat($('#carga_social').val())+parseFloat($('#cfo_otros').val()))*100)/100);
      $('#cfa_total').val(Math.ceil((parseFloat($('#sueldos_salarios').val())+parseFloat($('#cfa_otros').val()))*100)/100);
      $('#cif_total').val(Math.ceil($('#intereses').val()*100)/100);

      CalcularPorcentajes();
      CalcularCostoXViaje();
      CalcularUtilidadXKilometro();
      CalcularCostoXKilometro();
      CalcularGanancia();
      CalcularUtilidad();
    }

    //Calculos para cotizacion

    function CalcularIngreso()
    {
      if ($('#clientes').val() != 1) {
        $('#precio_km').val(0);
        $('#mostrarprecio').attr('hidden', 'hidden');
      }
      else {
        CalcularExcepcion();
      }

      $('#ingresos_viaje').val(Math.ceil($('#flete').val()*$('#presupuesto').val()));
      CalcularCostoXViaje();
      CalcularUtilidad();
      CalcularKmMensuales();
      CalcularVentaXKilometro();
      CalcularUtilidadXKilometro();
      CalcularPorcentajes();
      CalcularGanancia();
      if (data['resumen'] != undefined) {
        MostrarResumen();
      }
    }

    function CalcularExcepcion()
    {
      $('#mostrarprecio').removeAttr('hidden');
      $('#flete').val(Math.ceil($('#km_redondo').val()*$('#precio_km').val()));
    }

    function CalcularRedondo()
    {
      $('#km_redondo').val($('#km_uno').val()*$('#select_tipo').val());
      if($('#clientes').val() == 1){
        CalcularExcepcion();
      } 
      CalcularIngreso();
      CalcularKmMensuales();
      CalcularLitrosDiesel();
      CalcularVentaXKilometro();
      CalcularUtilidadXKilometro();
      CalcularCostoXKilometro();
      if (data['resumen'] != undefined) {
        MostrarResumen();
      }
    }

    function CalcularSueldoXKm()
    {
      if ($('#select_config').val() == 1) {     
        $('#sueldo_km').val(1.90);
      }
      else {
        $('#sueldo_km').val(2.10);
      }

      if (data['resumen'] != undefined) {
        MostrarResumen();
      }
    }

    function CalcularCostoXViaje()
    {
      $('#costo_viaje').val(Math.ceil((parseFloat($('#cvo_total').val())+parseFloat($('#cvm_total').val())+parseFloat($('#io_total').val())+parseFloat($('#cfo_total').val())+parseFloat($('#cfa_total').val())+parseFloat($('#cif_total').val()))/$('#presupuesto').val()*100)/100);

      CalcularVentaXKilometro();
    }

    function CalcularUtilidad()
    {
      $('#utilidad').val(Math.ceil(($('#flete').val()-$('#costo_viaje').val())*100)/100);

      CalcularCostoXKilometro();
    }

    function CalcularKmMensuales()
    {
      $('#km_mensuales').val(Math.ceil($('#km_redondo').val()*$('#presupuesto').val()*100)/100);
    }

    function CalcularLitrosDiesel()
    {
      $('#litros_diesel').val(Math.ceil($('#km_redondo').val()/$('#rendimiento').val()*100)/100);

      if (data['resumen'] != undefined) {
        MostrarResumen();
      }
    }

    function CalcularVentaXKilometro()
    {
      $('#venta_km').val(Math.ceil($('#flete').val()/$('#km_redondo').val()*100)/100);
    }

    function CalcularUtilidadXKilometro()
    {
      $('#utilidad_kilometro').val(Math.ceil($('#utilidad_operacion').val()/$('#presupuesto').val()/$('#km_redondo').val()*100)/100);
    }

    function CalcularCostoXKilometro()
    {
      $('#costo_kilometro').val(Math.ceil($('#costo_viaje').val()/$('#km_redondo').val()*100)/100);
    }

    function CalcularGanancia()
    {
      var porcentaje = Math.ceil(($('#utilidad_operacion').val()/$('#ingresos_viaje').val()*100)*100)/100;
      var faltante = Math.ceil((parseFloat($('#porcentaje_minimo').val()) - porcentaje)*100)/100;

      if (($('#utilidad_operacion').val() != 0) && ($('#ingresos_viaje').val() != 0) && ($('#porcentaje_minimo').val() != 0)) {
        if (porcentaje >= $('#porcentaje_minimo').val()) {
          if (!$('#alert_ganancia').hasClass('alert-success')) {
            $('#alert_ganancia').removeClass('alert-danger');
            $('#alert_ganancia').addClass('alert-success');
          }

          $('#alert_ganancia').empty();
          $('#alert_ganancia').append('<i class="fas fa-check-circle"></i> <strong>Ganancia aceptable <i>(<strong id="ganancia">+'+(faltante*-1)+'</strong>%)</i></strong><input name="status" value="Aceptable" hidden="hidden">'); 
          $('#ganancia').val('+'+(faltante*-1));
        }
        else {
          if (!$('#alert_ganancia').hasClass('alert-danger')) {
            $('#alert_ganancia').removeClass('alert-success');
            $('#alert_ganancia').addClass('alert-danger');
          }
          $('#alert_ganancia').empty();

          $('#alert_ganancia').append('<i class="fas fa-exclamation-circle"></i> <strong>Ganancia no aceptable <i>(<strong id="ganancia">-'+faltante+'</strong>%)</i></strong><input name="status" value="No aceptable" hidden="hidden">'); 
          $('#ganancia').val('-'+faltante);
        }
        $('#alert_ganancia').removeAttr('hidden');
      }

      CalcularFleteSugerido();
    }

    function CalcularFleteSugerido()
    {
      $('#sugerido').val(Math.ceil((parseFloat($('#utilidad_operacion').val())/parseFloat(($('#porcentaje_minimo').val())/100))/parseFloat($('#presupuesto').val())*100)/100);
    }

    function CambiarFlete()
    {
      $('#flete').val($('#sugerido').val());
      CalcularIngreso();
    }
  </script>
@endsection