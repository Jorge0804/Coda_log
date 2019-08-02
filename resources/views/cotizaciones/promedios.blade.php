@extends('vistas.base')

@section('css')
<style type="text/css">
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
</style>
@endsection

@section('contenido')
  <div class="row">
    @foreach($datos['mensuales'] as $key => $coti)
    @foreach($coti as $coti2)
    @if($coti->count())
    <div class="col-lg-12">
      <!-- Collapsable Card Example -->
      <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href={{'#card'.$key}} class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls={{'card'.$key}} >
          <h6 class="m-0 font-weight-bold text-primary">{{$key}}</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id={{'card'.$key}}>
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="overflow: scroll;">
                  <thead>
                  </thead>
                  <tfoot>
                  </tfoot>
                  <tbody>
                      <tr style="width: 100%">
                        <th>Precio diesel</th>
                        <td>$ {{$coti2->diesel->precio}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{$coti2->diesel->iva}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{$coti2->diesel->precio_iva}}</td>
                      </tr>
                      <tr>
                        <th>Sueldo por km</th>
                        <td>$ {{$coti2->sueldo_km}}</td>
                      </tr>
                      <tr>
                        <th>Unidades pagadas</th>
                        <td>{{$coti2->unidades_pagadas}}</td>
                      </tr>
                      <tr>
                        <th>% Incremento casetas</th>
                        <td>% {{$coti2->incremento_casetas}}</td>
                      </tr>
                      <tr>
                        <th>Kms mensuales</th>
                        <td>{{$coti2->kms_mensuales}}</td>
                      </tr>
                      <tr>
                        <th>Unidades operativas</th>
                        <td>{{$coti2->unidades_operativas}}</td>
                      </tr>
                      <tr>
                        <th>Viajes por mes</th>
                        <td>{{$coti2->viajes_mes}}</td>
                      </tr>
                      <tr>
                        <th>Kms por unidad</th>
                        <td>{{$coti2->kms_unidad}}</td>
                      </tr>
                      <tr>
                        <th>Viajes por unidad</th>
                        <td>{{$coti2->viajes_unidad}}</td>
                      </tr>
                      <tr>
                        <th>Distancia por viaje</th>
                        <td>{{$coti2->distancia_viaje}}</td>
                      </tr>
                        <th>Venta por viaje</th>
                        <td>4 {{$coti2->venta_viaje}}</td>
                      </tr>
                      <tr>
                        <th>Fletes</th>
                        <td>$ {{$coti2->total_ingreso}}</td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
      @endforeach
      @endforeach
    </div>

    <div class="row">
    <div class="col-lg-6">
      <!-- Collapsable Card Example -->
      <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href='#cardpro' class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls='cardpro' style="background-color: #4286f4">
          <h6 class="m-0 font-weight-bold text-white">Promedio</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id='cardpro'>
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="overflow: scroll;">
                  <thead>
                  </thead>
                  <tfoot>
                  </tfoot>
                  <tbody>
                      <tr style="width: 100%">
                        <th>Precio diesel</th>
                        <td>$ {{$datos['promedios']->diesel->precio}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{$datos['promedios']->diesel->iva}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{$datos['promedios']->diesel->precio_iva}}</td>
                      </tr>
                      <tr>
                        <th>Sueldo por km</th>
                        <td>$ {{$datos['promedios']->sueldo_km}}</td>
                      </tr>
                      <tr>
                        <th>Unidades pagadas</th>
                        <td>{{$datos['promedios']->unidades_pagadas}}</td>
                      </tr>
                      <tr>
                        <th>% Incremento casetas</th>
                        <td>% {{$datos['promedios']->incremento_casetas}}</td>
                      </tr>
                      <tr>
                        <th>Kms mensuales</th>
                        <td>{{$datos['promedios']->kms_mensuales}}</td>
                      </tr>
                      <tr>
                        <th>Unidades operativas</th>
                        <td>{{$datos['promedios']->unidades_operativas}}</td>
                      </tr>
                      <tr>
                        <th>Viajes por mes</th>
                        <td>{{$datos['promedios']->viajes_mes}}</td>
                      </tr>
                      <tr>
                        <th>Kms por unidad</th>
                        <td>{{$datos['promedios']->kms_unidad}}</td>
                      </tr>
                      <tr>
                        <th>Viajes por unidad</th>
                        <td>{{$datos['promedios']->viajes_unidad}}</td>
                      </tr>
                      <tr>
                        <th>Distancia por viaje</th>
                        <td>{{$datos['promedios']->distancia_viaje}}</td>
                      </tr>
                        <th>Venta por viaje</th>
                        <td>4 {{$datos['promedios']->venta_viaje}}</td>
                      </tr>
                      <tr>
                        <th>Fletes</th>
                        <td>$ {{$datos['promedios']->fletes}}</td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    <div class="col-lg-6">
      <!-- Collapsable Card Example -->
      <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href='#cardacu' class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls='cardacu' style="background-color: #EC6610">
          <h6 class="m-0 font-weight-bold text-white">Acumuludado</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id='cardacu'>
          <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="overflow: scroll;">
                 <thead>
                  </thead>
                  <tfoot>
                  </tfoot>
                  <tbody>
                      <tr style="width: 100%">
                        <th>Precio diesel</th>
                        <td>$ {{$datos['acumulados']->diesel->precio}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{$datos['acumulados']->diesel->iva}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ {{$datos['acumulados']->diesel->precio_iva}}</td>
                      </tr>
                      <tr>
                        <th>Sueldo por km</th>
                        <td>$ {{$datos['acumulados']->sueldo_km}}</td>
                      </tr>
                      <tr>
                        <th>Unidades pagadas</th>
                        <td>{{$datos['acumulados']->unidades_pagadas}}</td>
                      </tr>
                      <tr>
                        <th>% Incremento casetas</th>
                        <td>% {{$datos['acumulados']->incremento_casetas}}</td>
                      </tr>
                      <tr>
                        <th>Kms mensuales</th>
                        <td>{{$datos['acumulados']->kms_mensuales}}</td>
                      </tr>
                      <tr>
                        <th>Unidades operativas</th>
                        <td>{{$datos['acumulados']->unidades_operativas}}</td>
                      </tr>
                      <tr>
                        <th>Viajes por mes</th>
                        <td>{{$datos['acumulados']->viajes_mes}}</td>
                      </tr>
                      <tr>
                        <th>Kms por unidad</th>
                        <td>{{$datos['acumulados']->kms_unidad}}</td>
                      </tr>
                      <tr>
                        <th>Viajes por unidad</th>
                        <td>{{$datos['acumulados']->viajes_unidad}}</td>
                      </tr>
                      <tr>
                        <th>Distancia por viaje</th>
                        <td>{{$datos['acumulados']->distancia_viaje}}</td>
                      </tr>
                        <th>Venta por viaje</th>
                        <td>4 {{$datos['acumulados']->venta_viaje}}</td>
                      </tr>
                      <tr>
                        <th>Fletes</th>
                        <td>$ {{$datos['acumulados']->fletes}}</td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('javascript')
<script>
  $(document).ready(function() {
    $('.collapse').collapse('hide');
  });
</script>
@endsection