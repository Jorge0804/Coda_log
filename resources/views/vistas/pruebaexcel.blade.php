@extends('vistas.base')

@section('contenido')
<form action="{{url('/importarexcel')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
	@csrf

	<input type="file" name="import_file">
	<button class="btn btn-primary">Import</button>
	
</form>
@endsection

@section('javascript')
<script type="text/javascript">
	function probar(inp)
	{
		console.log(inp.val());
	}
</script>
@endsection