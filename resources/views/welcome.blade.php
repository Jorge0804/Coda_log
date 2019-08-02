@extends('vistas.base')
@section('contenido')
   <button type="button" class="btn btn-danger">button</button>
@endsection

@section('librerias')
<script type="text/javascript">
  $(document).ready(function() {
    alert('jsdkjs');
  });
</script>
@endsection