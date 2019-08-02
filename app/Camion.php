<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camion extends Model
{
    protected $table = 'camiones';

    public function tipo()
    {
    	return $this->HasOne(Tipo_configuracion::class, 'id', 'tipo_configuracion');
    }
}
