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
                      <th>Opciones</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Folio</th>
                      <th style="width: 100px;">Fecha</th>
                      <th>Cliente</th>
                      <th>Origen</th>
                      <th>Destino</th>
                      <th>Configuracion</th>
                      <th style="width: 100px;">Flete</th>
                      <th>km's un sentido</th>
                      <th>km's redondos</th>
                      <th>Opciones</th>
                    </tr>
                  </tfoot>
                  <tbody>
                  	@foreach($cotis as $coti)
	                    <tr>
                        <td>{{$coti['folio']}}</td>
	                      <td>{{$coti['fecha']}}</td>
	                      <td>{{$coti['cliente']['nombre']}}</td>
	                      <td>{{$coti['ruta']{'ciudad_origen'}['nombre']}}, {{$coti['ruta']['ciudad_origen']['estado']['nombre']}}</td>
	                      <td>{{$coti['ruta']['ciudad_destino']['nombre']}}, {{$coti['ruta']['ciudad_destino']['estado']['nombre']}}</td>
	                      <td>{{$coti['camion']['tipo_configuracion']['configuracion']}}</td>
	                      <td>$ {{number_format($coti['flete'], 2, '.', ',')}}</td>
	                      <td>{{$coti['kilometros_ida']}}</td>
	                      <td>{{$coti['total_kilometros']}}</td>
                        <td style="width: 120px">
                          <button data-toggle="modal" data-target="#modal_nombres" type="button" class="btn btn-success btn-sm" onclick="MandarNombres({{$coti->folio}}, 'descargar')"><i class="fas fa-download"></i></button>
                          <a data-toggle="modal" data-target="#modal_nombres" onclick="MandarNombres({{$coti->folio}}, 'visualizar')"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-file-pdf"></i></button></a>
                          <input type="text" id="direccion" value="{{url('/VisualizarPDF/'.$coti->folio)}}" hidden="hidden">
                          @if(session('usuario')->rol == 1)
                            <a title="Eliminar cotizacion" onclick="ElimiarCotizacion({{$coti->folio}})">
                              <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </a>
                          @endif
                        </td>
	                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <form method="GET" role="form" id="modal_form">
            @csrf
            <!-- The Modal -->
            <div class="modal fade" id="modal_nombres">
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title" id="titulo_modal">Escribe el nombre de los encargados</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal body -->
                  <div class="modal-body">
                    <div id="contenido_modal">
                        <div>
                          <label>Gerencia de operaciones logisticas:</label>
                          <br>
                          <input style="width: 100%;" type="text" class="form-control form-control-sm" value="" required="required" name="nombres[logistica]">
                        </div>
                        <br>
                        <div>
                          <label>Gerencia general:</label>
                          <br>
                          <input style="width: 100%;" type="text" class="form-control form-control-sm" value="" required="required" name="nombres[general]">
                        </div>
                        <br>
                        <div>
                          <label>Gerencia de transportes:</label>
                          <br>
                          <input style="width: 100%;" type="text" class="form-control form-control-sm" value="" required="required" name="nombres[transportes]">
                        </div>
                    </div>
                  </div>

                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-icon-split" id="boton_cambiar" >
                      <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="text" id="texto_boton">Confirmar</span>
                    </button>
                    <a href="#" class="btn btn-danger btn-icon-split" data-dismiss="modal">
                      <span class="icon text-white-50">
                        <i class="fas fa-times-circle"></i>
                      </span>
                      <span class="text">Cancelar</span>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </form>
@endsection

@section('librerias')
<!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
@endsection

@section('javascript')
  <script type="text/javascript">
    function MandarNombres(folio, tipo)
    {
      if (tipo == 'visualizar') {
        $('#modal_form').attr('action', "{{url('/VisualizarPDF')}}"+'/'+folio);
      }
      else {
        $('#modal_form').attr('action', "{{url('/DescargarPDF')}}"+'/'+folio);
      }
    }

    function ElimiarCotizacion(folio)
    {
      console.log(folio);
      swal({
          title: "¿Estás seguro de eliminar esta cotización?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Confirmar",
          cancelButtonText: "Cancelar",
          closeOnConfirm: false,
          closeOnCancel: false,
          showLoaderOnConfirm: true
        },
        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              url: "{{url('/EliminarCotizacion')}}",
              type: 'POST',
              dataType: 'json',
              data: {
                _token: "{{ csrf_token() }}",
                folio: folio,
              },
              success: function(respuesta){
               console.log(respuesta);
              },
              error: function(){
                swal({
                    title: 'Error!',
                    text: 'Algo salió mal',
                    type: "error",
                    position: 'top-end',
                    timer: 2100
                  });
              }
            }); 
            setTimeout(function () {
              swal("Completado", "El registro fue eliminado con exito", "success");
              location.reload();
            }, 800);
          } 
          else {
            swal("Cancelado", 'No se eliminó la cotización', "error");
          }
      }); 
    }
  </script>
@endsection