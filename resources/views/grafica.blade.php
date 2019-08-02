@extends('vistas.base')

@section('contenido')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cotizaciones</h6>
    </div>
    <div class="card-body" id="contenedor">
    	{!!$grafica!!}
    </div>
</div>
@endsection