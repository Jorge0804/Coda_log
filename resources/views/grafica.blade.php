@extends('vistas.base')

@section('contenido')
	<div class="card shadow mb-4">
	    <div class="card-header py-3">
	        <h6 class="m-0 font-weight-bold text-primary">Graficas</h6>
	    </div>
	    <div class="card-body" id="contenedor1">
	    	<div class="card-body" id="contenedor1">
	    		{!!$grafica1!!}
	    	</div>
	    	<div class="card-body" id="contenedor2">
	    		{!!$grafica2!!}
	    	</div>
	    </div>
	</div>
@endsection