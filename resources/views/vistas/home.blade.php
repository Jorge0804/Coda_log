@extends('vistas.base')

@section('contenido')
<button type="button" class="btn btn-danger btn-sm delete"><i class="la la-small la-trash"></i></button>
  <script type="text/javascript">
$('.delete').on('click', function() {

        swal({
          title: "¿Desea eliminar el usuario?",
          text: "",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Si!!",
          cancelButtonText: "No!!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm) {
          if (isConfirm) {

            swal({
                title:'¡El usuario será eliminado!',
                text: '',
                type: 'success'
            }, 
            function() {
              $("#myform").submit();
            });

          } else {

            swal("Cancelled", "El usuario no será eliminado!!", "error");

          }
        });

    })
  </script>
@endsection