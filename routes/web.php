<?php
use Illuminate\Http\Request;
use App\Reporte_mensual;
use App\CIF_mensual;
use App\Ciudad;
use App\Cotizacion;
use App\cvo_mensual;
use App\Http\Controllers\SweetAlertController;

/*Rutas del usuario*/
Route::get('/home', 'controller@Home');
Route::get('/', 'UsuarioController@mostrarformlogin')->name('login');
Route::get('/FormRegistro', 'UsuarioController@mostrarformregistro');
Route::post('/Registrar', 'UsuarioController@registrar');
Route::post('/Iniciar', 'UsuarioController@iniciarsesion');
Route::get('/CerrarSesion', 'UsuarioController@CerrarSesion');
Route::get('/GestionarUsuarios', 'UsuarioController@FormGestionar');
Route::post('/EliminarUsuario', 'UsuarioController@EliminarUsuario');
Route::post('/RegPrimerUsuario', 'UsuarioController@RegPrimerUsuario');

/*Rutas para graficas*/
Route::get('/graficas', 'controller@graficas');

/*Rutas de cotizaciones*/
Route::get('/CotiRegistradas', 'CotizacionController@MostrarCotizaciones')->name('registradas');
Route::get('/mensuales', 'controller@mostrarmensuales');
Route::get('/formRegistrarCotiMensual', 'CotizacionController@FormrRegistrarMensual');
Route::post('/Resumenes', 'CotizacionController@SacarResumenMensual');
Route::post('/RegistrarMensual', 'CotizacionController@RegistrarMensual');
Route::get('/FormCotizar', 'CotizacionController@FormCotizar')->name('inicio');
Route::post('/AgregarCliente', 'CotizacionController@AgregarCliente');
Route::post('/AgregarConfiguracion', 'CotizacionController@AgregarConfiguracion');
Route::post('/AgregarCiudad', 'CotizacionController@AgregarCiudad');
Route::get('/RegistrarCoti', 'CotizacionController@RegistrarCoti');
Route::post('/ActualizarReporte', 'CotizacionController@ActualizarReporte');
Route::post('/EliminarCotizacion', 'CotizacionController@EliminarCotización');

/*Rutas de excel*/
Route::post('/importarexcel', 'ExcelController@importar');
Route::post('/ObtenerMes', 'ExcelController@ObtenerMes');
Route::post('/RegistrarNuevosDatos', 'ExcelController@RegistrarNuevosDatos');

/*Consultas*/
Route::post('/VerificarReporte', 'CotizacionController@VerificarReporte');

/*Rutas para info*/
Route::post('/ObtenerMeses', 'CalculosController@ObtenerMeses');
Route::post('/ObtenerAños', 'CalculosController@ObtenerAños');
Route::post('/ObtenerMensual', 'CalculosController@ObtenerMensual');
Route::post('/SacarResumen', 'CalculosController@SacarResumen');

Route::get('/pruebacd', function(){
	return Ciudad::where('estado', '=', 5)->get();
});
Route::get('prueba', function(){
	//return session('usuario');
	return Cotizacion::all();
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

Route::get('/boton', 
	function(){
		alert()->success('Success Message', 'Optional Title');
		return view('vistas.home');
	}
);