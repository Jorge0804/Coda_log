<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SweetAlertController extends Controller
{
    public static function MensajeCorrecto()
    {
    	alert()->message('Notificación solo con mensaje');
    }
}
