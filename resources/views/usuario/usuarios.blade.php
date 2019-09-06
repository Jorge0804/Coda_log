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
      <h6 class="m-0 font-weight-bold text-primary">Usuarios registrados</h6>
    </div>
    <div class="card-body">
      <a data-toggle="modal" data-target="#modal_añadir" id="cargar_Resumen" href="" class="btn btn-primary btn-icon-split form-control-sm" style="margin-bottom: 10px">
        <span class="icon text-white-50">
          <i class="fas fa-user-plus" style="color: white;"></i>
        </span>
        <span class="text">Añadir usuario</span>
      </a>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="overflow: scroll;">
          <thead>
            <tr>
              <th>Username</th>
              <th>Nombre</th>
              <th>Tipo de usuario</th>
              <th>Descripción</th>
              <th>Eliminar</th>
            </tr>
          </thead>
          <tbody>
            @if(count($usuarios))
              @foreach($usuarios as $usuario)
                @if($usuario['id'] !=   Session::get('usuario')['id'] && $usuario['estado'] != 0)
                  <tr>
                    <td>{{$usuario['user_name']}}</td>
                    <td>{{$usuario['nombre']}}</td>
                    <td>{{$usuario['rol']['tipo']}}</td>
                    <td>{{$usuario['rol']['descripcion']}}</td>
                    <td style="width: 120px">
                      <a data-toggle="modal" data-target="#modal_nombres" title="Eliminar usuario" onclick="EliminarUsuario({{$usuario['id']}})">
                        <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                      </a>
                    </td>
                  </tr>
                @endif
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <form method="POST" role="form" id="modal_form" onsubmit="AñadirUsuario(); return false;">
    @csrf
    <!-- The Modal -->
    <div class="modal fade" id="modal_añadir">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title" id="titulo_modal">Añadir un nuevo usuario</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div id="contenido_modal">
              <div class="tipos_añadir">
                <div class="col-sm-12 form-inline">
                  <div class="col-sm-6">
                    <label style="width: 100%">Nombre(s)</label> 
                    <input type="text" name="nombre" id="nombre" class="form-control form-control-sm" value="" spattern="" title="" autofocus="true" required="required" style="width: 100%;"> 
                  </div>
                  <div class="col-sm-6">
                    <label>Correo/Nombre de usuario</label> 
                    <input type="text" name="correo" id="correo" class="form-control form-control-sm" value="" spattern="" title="" autofocus="true" required="required" style="width: 100%;">
                  </div>
                </div>
                <br>
                <div class="col-sm-12 form-inline">
                  <div class="col-sm-6">
                    <label>Contraseña</label> 
                    <input type="password" name="pass" id="pass" class="form-control form-control-sm" value="" spattern="" title="" autofocus="true" required="required" style="width: 100%;"> 
                  </div>
                  <div class="col-sm-6">
                    <label>Repite tu contraseña</label> 
                    <input type="password" name="pass2" id="pass2" class="form-control form-control-sm" value="" spattern="" title="" autofocus="true" required="required" style="width: 100%;"> 
                  </div>
                </div>
                <br>
                <div>
                  <label>Tipo de usuario</label> 
                  <select name="rol" id="rol" class="form-control" required="required">
                    @foreach($roles as $rol)
                      <option value="{{$rol['id']}}">{{$rol['tipo']}} - <i>{{$rol['descripcion']}}</i></option>
                    @endforeach
                  </select>
                </div>
              </div>
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
    function AñadirUsuario()
    {
      $.ajax({
        url: "{{url('/Registrar')}}",
        type: 'POST',
        dataType: 'json',
        data: {
          _token: "{{ csrf_token() }}",
          datos: $('#modal_form').serialize()
        },
        success: function(respuesta){
          if (respuesta['estatus'] == 'bien') {
            $('#modal_añadir').modal('toggle');
            swal({
              title: 'Exitoso!',
              text: respuesta['mensaje'],
              type: "success",
              position: 'top-end',
              timer: 2100
            });
            location.reload();
          }
          else {
            swal({
              title: 'Error!',
              text: respuesta['mensaje'],
              type: "error",
              position: 'top-end',
              timer: 2100
            });
          }
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
    }

    function EliminarUsuario(id)
    {
      console.log(id);
      swal({
          title: "¿Estás seguro de eliminar este usuario?",
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
              url: "{{url('/EliminarUsuario')}}",
              type: 'POST',
              dataType: 'json',
              data: {
                _token: "{{ csrf_token() }}",
                info: id,
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
              swal("Completado", "Este usuario fue eliminado", "success");
              location.reload();
            }, 800);
          } 
          else {
            swal("Cancelado", 'El usuario no fue eliminado', "error");
          }
      }); 
    }
  </script>
@endsection