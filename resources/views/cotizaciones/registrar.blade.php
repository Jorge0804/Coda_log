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
    
    table {
      font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
        font-size: 12px;    
        margin: 15px;     
        width: 480px; 
        text-align: left;    
        border-collapse: collapse; 
    }

    th {  
      font-size: 13px;     
      font-weight: normal;     
      padding: 8px;     
      background: #b9c9fe;
        border-top: 4px solid #aabcfe;    
        border-bottom: 1px solid #fff; 
        color: #039; 
    }

    td {    
      padding: 8px;     
      background: #e8edff;     
      border-bottom: 1px solid #fff;
        color: #669;    
        border-top: 1px solid transparent; 
    }

    tr:hover td { 
      background: #d0dafd; 
      color: #339; 
    }

    input.input-table{
      background-color: #e3e6f0; 
      border-color: #039; 
      color: #039; 
      border: 0; 
      text-align: center; 
      width: 150px;
    }

  .image-upload
  {
    border-color: grey;
    border-width: 10px;
    border-radius: 20px;
    margin-left: 70px;
  }
  .image-upload > input
  {
      display: none;
  }

  .image-upload img
  {
      width: 50px;
      margin-right: 100px;
      cursor: pointer;
  }

  #radioBtn .notActive{
    color: #3276b1;
    background-color: #fff;
  }
  </style>

  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('contenido')
  <div class="row">
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample" style="background-color: #252526">
          <h6 class="m-0 font-weight-bold" style="color: #EC6610;">Registrar mensual</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="collapseCardExample">
          <div class="card-body">

            <h2 id="texto_carga">Fecha/Cargar archivo</h2>
            <div class="form-group form-inline col-lg-12">

              <form action="{{url('/importarexcel')}}" method="post" enctype="multipart/form-data" id="formfile">
                @csrf

                <div class="form-inline">
                  <div class="image-upload col-sm-1" id="contenedor-excel">
                              
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="input" class="col-sm-2 control-label">Fecha:&nbsp;&nbsp;&nbsp;</label>
                    <div class="col-sm-1">
                      <input type="date" name="fecha" id="fecha_archivo" class="form-control form-control-sm" 
                      @if(Session::has('fecha'))
                        value="{{Session::get('fecha')}}"
                      @else
                        value=""
                      @endif 
                        required="required" title="" onchange="MostrarInput()">
                    </div>
                  </div>
                </div>
              </form>
                       
            </div>
            <hr>
            <form method="GET" action="{{url('/RegistrarMensual')}}">
              @csrf

              <button type="submit" class="btn btn-primary">Submit</button>

              <input type="date" name="fecha_reg" id="fecha_reg" hidden="hidden">

              <h2>Diesel</h2>
              <div class="form-group form-inline">

                <label>Buscar precio &nbsp;</label>
                <select name="periodo" id="valores" class="form-control form-control-sm" onchange="ActualizarPrecio()">
                            
                </select>
                <input type="text" name="diesel_id" hidden="hidden" id="diesel_id">
                          &nbsp;&nbsp;

                <label>costo: &nbsp;</label>
                <input type="number" name="precio_diesel" id="precio" class="form-control form-control-sm" 
                @if(Session::has('reporte11'))
                  value="{{Session::get('reporte11')['Precio de Diesel (sin IVA) con % Incremento 2019']}}" 
                @else
                  value=""
                @endif 
                required="required" step="any">
                &nbsp; &nbsp;

                <label>iva: &nbsp;</label>
                <input type="number" name="iva" id="iva" class="form-control form-control-sm" 
                @if(Session::has('reporte11'))
                  value="1.00" 
                @else
                  value=""
                @endif 
                required="required" step="any">
                &nbsp; &nbsp;


                <label>&nbsp;¿Aplicar iva? &nbsp;</label>
                <label class="switch">
                  <input type="checkbox" onclick="ApilcarIva()" value="">
                  <span class="slider round"></span>
                </label>

              </div>
              <hr>

  <!------------------------------------------Info General------------------------------------------->

              <div class="row">
                <div class="form-group form-inline col-lg-12">
                  <br><br>
                  @if(Session::has('reporte'))
                    @foreach(Session::get('reporte')['Info General'] as $key => $valor)
                      @if($key)
                        <div class="form-group form-inline col-lg-6">
                          <label class="col-sm-5">{{$key}} &nbsp;</label>
                          <input step="any" type="number" name="Info General[{{$key}}]" id="{{str_replace(' ', '', $key)}}" class="form-control form-control-sm" required="required" value="{{$valor}}" onkeyup="Porcentajes_CostoXKM()">
                          <br><br>
                        </div>
                      @endif
                    @endforeach
                  @endif
                </div>
              </div>           
            </div>
            <hr>

  <!--------------------------------------Apartado del reporte mensual---------------------------------->

            @if(Session::has('reporte'))
              @foreach(Session::get('reporte') as $key1 => $reporte)
                @if($key1 != 'Info General')
                  <a href="{{'#'.str_replace(' ', '_', $key1)}}" class="d-block card-header py-4" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="{{str_replace(' ', '_', $key1)}}">
                    <h5>{{$key1}}</h5>
                  </a>
                  <div class="collapse show" id="{{str_replace(' ', '_', $key1)}}">
                    <div class="card-body" id="reporte">
                      <table class="table table-condensed" id="{{str_replace(' ', '', $key1)}}" width="100%" cellspacing="0">
                        <thead>
                        </thead>
                        <tbody>
                          @foreach($reporte as $key => $rep)
                            @if($key)
                              <tr>
                                <td>{{$key}}</td>
                                <td><input type="number" name="{{$key1}}[{{$key}}]" id="{{str_replace(' ', '', $key1)}}_{{str_replace(array('(', ')', ' ', '.', ','), array('', '', '', '', ''), $key)}}" class="form-control form-control-sm input-table" value="{{round($rep, 2, PHP_ROUND_HALF_UP)}}" onkeyup="Porcentajes_CostoXKM()" onclick="Porcentajes_CostoXKM()"></td>
                                <td><output id="porcentaje">---</output></td>
                                <td><output id="km">---</output></td>
                              </tr>
                            @endif
                          @endforeach
                          @if($key1 != 'Total de Costos Variables' && $key1 != 'Total de Fijos y Administracion')
                            <tr>
                              <th>Total</th>
                              <th><input type="number" name="" id="{{str_replace(' ', '', $key1)}}_total" class="form-control form-control-sm input-table" value="" onkeyup="Porcentajes_CostoXKM()" onclick="Porcentajes_CostoXKM()" step="any"></th>
                              <th><output id="porcentaje">---</output></th>
                              <th><output id="km">---</output></th>
                            </tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </div>
                @endif
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>

    <!------------------------------------------Apartado del resumen------------------------------------>

    @if(Session::has('resumen'))
      <div class="col-lg-12">
        <div class="card shadow mb-4">
          <!-- Card Header - Accordion -->
          <a href="#collresumen" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collresumen">
            <h6 class="m-0 font-weight-bold text-primary">Resumen</h6>
          </a>
          <!-- Card Content - Collapse -->
          <div class="collapse show" id="collresumen">
            <div class="card-body">
              <table class="table table-condensed" id="resumen" width="100%" cellspacing="0">
                <thead>
                </thead>
                <tbody>
                  @foreach(Session::get('resumen') as  $key1 => $resumen)
                    @if($key1 != 'Otros Gastos')
                      <tr>
                        <th>{{$key1}}</th>
                        <th><input type="number" name="Resumen_{{$key1}}[total]" id="total_{{str_replace(' ', '', $key1)}}" class="form-control form-control-sm input-table" value="" step="any" onkeyup=""></th>
                        <th><output id="porcentaje">---</output></th>
                        <th><output id="km">---</output></th>
                      </tr>
                      @foreach($resumen as $key2 => $res)
                        <tr>
                          <td>{{$res->nombre}}</td>
                          <td><input type="number" name="Resumen_{{$key1}}[{{$res->nombre}}]" id="{{str_replace(array('_', ' ', '.'), array('','', '_'), $key1.$res->nombre)}}" class="form-control form-control-sm input-table" value="0" step="any" onkeyup="SacarTotalesResumen()"></td>
                          <td><output id="porcentaje">---</output></td>
                          <td><output id="km">---</output></td>
                        </tr>
                      @endforeach
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @endif
  </form>

  <!----------------------------------Modal para registrar nuevos datos--------------------------------->

  <form method="POST" action="{{url('/RegistrarNuevosDatos')}}" role="form" id="modal_form" onsubmit="ActualizarBD(); return false;">
    <!-- The Modal -->
    <div class="modal fade" id="modal_añadir" data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" id="titulo_modal">Se encontraron nuevos datos</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <!-- Modal body -->
          <div class="modal-body">
            <div id="contenido_modal">
              <div style="padding-right: 30px;">
                <table class="table table-condensed" style="margin-right: 200px; width: 100%;">
                  <thead>
                  </thead>
                  <tbody>
                    @if(Session::has('nuevos'))
                      @foreach(Session::get('nuevos') as $encabezado => $nuevos)
                      <tr>
                        <th colspan="8">{{$encabezado}}</th>
                      </tr>
                        @foreach($nuevos as $elemento => $nuevo)
                        <tr>
                          <td colspan="4">{{trim($elemento)}}</td>
                          <td colspan="4">
                            <select name="{{trim($elemento)}}" id="input" class="form-control form-control-sm" required="required">
                              @foreach(Session::get('resumen')[$encabezado] as $res)
                                <option value="{{$res->id}}">{{$res->nombre}}</option>
                              @endforeach
                            </select>
                          </td>
                        </tr>
                        @endforeach
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-icon-split" id="boton_cambiar" >
              <span class="icon text-white-50">
                <i class="fas fa-sync-alt" style="color: white"></i>
              </span>
              <span class="text" id="texto_boton">Actualizar</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('javascript')
<script type="text/javascript">
  var flag = true;
  $(document).ready(function() {
    if ('{{Session::has("nuevos")}}' && '{{Session::get("nuevos")}}' != '[]') {
      $('#modal_añadir').modal('show');
    }

    if ('{{Session::has('reporte')}}') {
      Porcentajes_CostoXKM();
      MandarFecha();
    }

    $('#radioBtn a').on('click', function(){
      var sel = $(this).data('title');
      var tog = $(this).data('toggle');
      $('#'+tog).prop('value', sel);
      
      $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
      $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
    });
  });

  function Porcentajes_CostoXKM(){
    var total = $('#TotalIngreso').val();
    var kms = $('#KmsMensuales').val();
    var datos = $('#reporte table');

    datos.each(function(index, el) {
      var partes = $('#'+el.id+' td input');
      partes.each(function(index, el) {
        $('#'+el.id).parent('td').siblings('td').children('#porcentaje').text(Math.ceil(el.value/total*10000)/100+'%');
        $('#'+el.id).parent('td').siblings('td').children('#km').text('$'+Math.ceil(el.value/kms*100)/100);
      });
    });

      CalcularResumen(datos);
      CalcularTotales(datos);
  }

  function CalcularTotales(datos)
  {
    datos.each(function(index, el) {
      $('#'+el.id).each(function(index, el) {
        var sum = 0;
        $('#'+el.id+' input').each(function(index, el) {
          if (el.id != 'CostoVariabledeOperación_TotalCostoVariabledeOperación' && el.id != 'CostoVariabledeOperación_MargendeOperación' && el.id != 'CostoVariabledeOperación_total' && el.id != 'CostoVariabledeMantenimiento_TotalCostoVariabledeMantenimiento' && el.id != 'CostoVariabledeMantenimiento_total' && el.id != 'TotaldeCostosVariables_TotaldeCostosVariables' && el.id != 'IncidenciasOperativas_TotalIncidenciasOperativas' && el.id != 'IncidenciasOperativas_total' && el.id != 'CostoFijodeOperación_TotalCostoFijodeOperación' && el.id != 'CostoFijodeOperación_total' && el.id != 'CostoFijodeAdministracion_TotalCostoFijodeAdministracion' && el.id != 'CostoFijodeAdministracion_total' && el.id != 'TotaldeFijosyAdministracion_TotaldeFijosyAdministracion' && el.id != 'OtrosGastos_total') {
            sum += parseFloat(el.value);
          }
        });
        $('#'+el.id+'_total').val(sum);
      });
    });
  }

  function CalcularResumen(datos)
  {
    var reporte = [];
    var resumen = [];
    var valores = [];
    var list = @json(Session::get('referencias'));

    datos.each(function(index, el) {
      var partes = $('#'+el.id+' td input');
      var arreglo = [];
      partes.each(function(index, el) {
        var llave = el.name.split('[', 2)[1].replace(']', '');
        arreglo[llave] = el.value;
      });
      reporte[el.id] = arreglo;
    });  

    list.forEach((item) => {
      var indice = item.resumen.encabezado.replace(/ /g, '');
      var nom = item.resumen.nombre;

      if (!valores[indice+nom.replace(/ /g, '')]) {
        valores[indice+nom.replace(/ /g, '')] = 0;
      }

      if(nom != 'Intereses' && nom != 'Arrendamientos' && (parseFloat(reporte[indice][item.nombre]) > 0 || parseFloat(reporte[indice][item.nombre]) < 0)) 
      {
        valores[indice+nom.replace(/ /g, '')] += parseFloat(reporte[indice][item.nombre]); 
      }
      else if (nom == 'Intereses') {
        valores[indice+nom.replace(/ /g, '')] += parseFloat(reporte['OtrosGastos']['Depreciaciones']);
      }
      else if (nom == 'Arrendamientos') {
        console.log(reporte['OtrosGastos']['Depreciaciones']+reporte['CostoFijodeOperación']['Arrendamiento de unidades']);
        console.log('---');
        valores[indice+nom.replace(/ /g, '')] = parseFloat(reporte['CostoFijodeOperación']['Arrendamiento de unidades']) + parseFloat(reporte['OtrosGastos']['Depreciaciones']);
        console.log(valores[indice+nom.replace(/ /g, '')]);
      }
    });
    MostrarResumen(valores);
  }

  function MostrarResumen(valores)
  {
    console.log(valores);
    var inputs = $('#resumen input');
    inputs.each(function(index, el) {
      if (valores[el.id]) {
        el.value = parseFloat(valores[el.id])*-1;  
      }
    });
    SacarTotalesResumen();
  }

  function SacarTotalesResumen()
  {
    $('#total_CostoVariabledeOperación').val(parseFloat($('#CostoVariabledeOperaciónDiesel').val())+parseFloat($('#CostoVariabledeOperaciónAutopistas').val())+parseFloat($('#CostoVariabledeOperaciónSueldo').val())+parseFloat($('#CostoVariabledeOperaciónOtros').val()));
    $('#total_CostoVariabledeMantenimiento').val(parseFloat($('#CostoVariabledeMantenimientoRefaccionesyMO').val())+parseFloat($('#CostoVariabledeMantenimientoLlantas').val()));
    $('#total_IncidenciasOperativas').val(parseFloat($('#IncidenciasOperativasDeduciblesyOtros').val()));
    $('#total_CostoFijodeOperación').val(parseFloat($('#CostoFijodeOperaciónArrendamientos').val())+parseFloat($('#CostoFijodeOperaciónSeguros').val())+parseFloat($('#CostoFijodeOperaciónCargaSocial').val())+parseFloat($('#CostoFijodeOperaciónOtros').val()));
    $('#total_CostoFijodeAdministracion').val(parseFloat($('#CostoFijodeAdministracionSueldosySalarios').val())+parseFloat($('#CostoFijodeAdministracionOtros').val()));
    $('#total_CostoIntegraldelFinanciamiento').val(parseFloat($('#CostoIntegraldelFinanciamientoIntereses').val()));
  }

  function ActualizarBD()
  {
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

      },
      error: function(){
        console.log('algo salio mal');
      }
    });
  }

  function MostrarInput()
  {
    console.log($('#fecha_archivo').val());
    if (flag) {
      $('#contenedor-excel').append('<label for="import"><img src="img/excel.ico" alt ="Click aquí para subir tu foto" title ="Click aquí para cargar archivo de excel" > </label><input name="import_file" id="import" type="file" onchange="SubmitFormulario()" />'); 

      flag = false;
    }
    MandarFecha();
  }

  function MandarFecha()
  {
    console.log($('#fecha_archivo').val());
    $('#fecha_reg').val($('#fecha_archivo').val());
  }

  function SubmitFormulario()
  {
    $('#formfile').submit();
  }
</script>
@endsection