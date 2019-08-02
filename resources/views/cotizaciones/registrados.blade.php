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
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Cotizaciones</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="overflow: scroll;">
                  <thead>
                    <tr>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Origen</th>
                      <th>Destino</th>
                      <th>Configuracion</th>
                      <th>Flete</th>
                      <th>km's un sentido</th>
                      <th>km's redondos</th>
                      <th>Reporte</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Folio</th>
                      <th>Fecha</th>
                      <th>Cliente</th>
                      <th>Origen</th>
                      <th>Destino</th>
                      <th>Configuracion</th>
                      <th>Flete</th>
                      <th>km's un sentido</th>
                      <th>km's redondos</th>
                      <th>Reporte</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  	@foreach($cotis as $coti)
	                    <tr>
                        <td>{{$coti->folio}}</td>
	                      <td>{{$coti->fecha}}</td>
	                      <td>{{$coti->cliente->nombre}}</td>
	                      <td>{{$coti->ruta->ciudad_origen->nombre}}, {{$coti->ruta->ciudad_origen->estado->nombre}}</td>
	                      <td>{{$coti->ruta->ciudad_destino->nombre}}, {{$coti->ruta->ciudad_destino->estado->nombre}}</td>
	                      <td>{{$coti->camion->tipo_configuracion->configuracion}}</td>
	                      <td>$ {{$coti->flete}}</td>
	                      <td>{{$coti->kilometros_ida}}</td>
	                      <td>{{$coti->total_kilometros}}</td>
                        <td style="width: 120px">
                          <a href="{{url('/DescargarPDF/'.$coti->folio)}}"><button type="button" class="btn btn-success btn-sm"><i class="fas fa-download"></i></button></a>
                          <a href="{{url('/VerCoti/'.$coti->folio)}}"><button type="button" class="btn btn-warning btn-sm"><i class="fas fa-eye"></i></button></a>
                          <a href="{{url('/VisualizarPDF/'.$coti->folio)}}"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i></button></a>
                        </td>
	                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
@endsection

@section('librerias')
<!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
@endsection