<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RezaAr\Highcharts\Facade as Chart;

class GraficaController extends Controller
{
    public function __construct()
    {
    	$this->middleware('CheckLogin');
    }

    public static function Gpay($cotis)
    {
    	$datos = collect([]);
    	foreach($cotis as $coti)
    	{
    		$datos->push([
    			'name'=> 'fecha: '.$coti->fecha,
	            'y' => $coti->flete,
	       		'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
	            'sliced' => 'true',
    		]);
    	}

    	$chart = Chart::title([
	        'text' => 'Grafica de ventas',
	    ])
	    ->chart([
	        'type'     => 'pie', 
	        'renderTo' => 'contenedor', 
	    ])
	    ->subtitle([
	        'text' => 'fletes mensuales',
	    ])
	    ->colors([
	        '#0c2959'
	    ])
	    ->xaxis([
	        'categories' => ['dia 1', 'dia 2', 'dia 3'],
	        'labels'     => [
	            'rotation'  => 15,
	            'align'     => 'top',
	        ],
	    ])
	    ->yaxis([
	        'text' => 'This Y Axis',
	    ])
	    ->legend([
	        'layout'        => 'vertikal',
	        'align'         => 'right',
	        'verticalAlign' => 'middle',
	    ])
	    ->series(
	        [
	            [
	                'name'  => 'flete',
	                'data'  => $datos,
	            ],
	        ]
	    )
	    ->display();

	    return $chart;
    }


    public static function Glinea($cotis)
    {
    	$datos = collect([]);
    	foreach ($cotis as $coti) {
    		$datos->push($coti->flete);
    	}
    	
    	$chart = Chart::title([
	        'text' => 'Grafica de ventas',
	    ])
	    ->chart([
	        'type'     => 'line', 
	        'renderTo' => 'contenedor', 
	    ])
	    ->subtitle([
	        'text' => 'Cantidad de ventas por dias',
	    ])
	    ->colors([
	        '#0c2959'
	    ])
	    ->xaxis([
	        'categories' => ['d1', 'd2', 'd3', 'd4', 'd5'],
	        'labels'     => [
	            'rotation'  => 15,
	            'align'     => 'top',
	        ],
	    ])
	    ->yaxis([
	        'text' => 'This Y Axis',
	    ])
	    ->legend([
	        'layout'        => 'vertikal',
	        'align'         => 'right',
	        'verticalAlign' => 'middle',
	    ])
	    ->series(
	        [
	            [
	                'name'  => 'fletes',
	                'data'  => $datos,
	                'color' => '#0c2959',
	            ],
	        ]
	    )
	    ->display();

	    return $chart;	
    }
}
