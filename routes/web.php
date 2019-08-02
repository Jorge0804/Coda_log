<?php
use Illuminate\Http\Request;
use App\Reporte_mensual;
use App\CIF_mensual;
use App\Ciudad;
use App\Cotizacion;
use App\cvo_mensual;
use RealRashid\SweetAlert\Facades\Alert;

/*Rutas del usuario*/
Route::get('/home', 'controller@Home')->name('inicio');
Route::get('/', 'UsuarioController@mostrarformlogin')->name('login');
Route::get('/FormRegistro', 'UsuarioController@mostrarformregistro');
Route::post('/Registrar', 'UsuarioController@registrar');
Route::post('/Iniciar', 'UsuarioController@iniciarsesion');
Route::get('/CerrarSesion', 'UsuarioController@CerrarSesion');

/*Rutas para graficas*/
Route::get('/graficas', 'controller@graficas');

/*Rutas de cotizaciones*/
Route::get('/CotiRegistradas', 'controller@vercoti');
Route::get('/mensuales', 'controller@mostrarmensuales');
Route::get('/formRegistrarCotiMensual', 'CotizacionController@FormrRegistrarMensual');
Route::post('/Resumenes', 'CotizacionController@SacarResumenMensual');
Route::get('/RegistrarMensual', 'CotizacionController@RegistrarMensual');
Route::get('/FormCotizar', 'CotizacionController@FormCotizar');
Route::post('/AgregarCliente', 'CotizacionController@AgregarCliente');
Route::post('/AgregarConfiguracion', 'CotizacionController@AgregarConfiguracion');
Route::post('/AgregarCiudad', 'CotizacionController@AgregarCiudad');
Route::get('/RegistrarCoti', 'CotizacionController@RegistrarCoti');

/*Rutas de excel*/
Route::post('/importarexcel', 'ExcelController@importar');
Route::post('/ObtenerMes', 'ExcelController@ObtenerMes');
Route::post('/RegistrarNuevosDatos', 'ExcelController@RegistrarNuevosDatos');

/*Rutas para info*/
Route::post('/ObtenerMeses', 'CalculosController@ObtenerMeses');
Route::post('/ObtenerAños', 'CalculosController@ObtenerAños');
Route::post('/ObtenerMensual', 'CalculosController@ObtenerMensual');
Route::post('/SacarResumen', 'CalculosController@SacarResumen');

Route::get('/pruebacd', function(){
	return Ciudad::where('estado', '=', 5)->get();
});
Route::get('prueba', function(){
	foreach (cvo_mensual::all() as $value) {
		foreach ($value as $key => $v) {
			return $value['id'];
		}
	}
	return Reporte_mensual::where('mes', '=', 1)->with('cvm')->with('cvo_mensual')->get();
	//return Reporte_mensual::with('cvo')->with('cvo_mensual')->with('cvm_mensual')->with('io_mensual')->with('cfo_mensual')->with('cfa_mensual')->with('cif_mensual')->with('cvm')->with('io_mensual')->with('io')->get();
});
Route::get('promedio', function(){
	$cotis = Reporte_mensual::with('cvo')->with('cvo_mensual')->orderby('mes')->get();
	$sum = 0;

	foreach ($cotis as $coti) {
		$cvo = cvo_mensual::where('id', '=', $coti->cvo_mensual)->first();
		$sum += $cvo->total/9;
	}
	return $sum;
});

/*PDF*/
Route::get('/pdfprueba', 'PDFController@ReporteCotizacion');
Route::get('/Imprimir', 'PDFController@ImprimirReporte');
Route::get('/DescargarPDF/{folio}', 'PDFController@DescargarPDF');
Route::get('/VisualizarPDF/{folio}', 'PDFController@VisualizarPDF');

Route::get('/redirect', function(){
	alert('<a href="#">Presiona aqui</a>')->html()->persistent("No, thanks");
	return redirect('/');
});

Route::get('/boton', 
	function(){
		alert()->error('Title','Lorem Lorem Lorem');
		return view('vistas.base');
	}
);