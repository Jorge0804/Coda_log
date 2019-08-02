<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function cliente()
    {
    	return $this->HasOne(Cliente::class, 'id', 'cliente_id');
    }

    public function camion()
    {
    	return $this->HasOne(Camion::class, 'id', 'camion_id');
    }

    public function ruta()
    {
    	return $this->HasOne(Ruta::class, 'id', 'ruta_id');
    }

    public function cf()
    {
        return $this->HasOne(CF::class, 'id', 'cf_id');
    }

    public function cfa()
    {
        return $this->HasOne(CFA::class, 'id', 'cfa_id');
    }

    public function cfo()
    {
        return $this->HasOne(CFO::class, 'id', 'cfo_id');
    }

    public function cvm()
    {
        return $this->HasOne(CVM::class, 'id', 'cvm_id');
    }

    public function cvo()
    {
        return $this->HasOne(CVO::class, 'id', 'cvo_id');
    }

    public function io()
    {
        return $this->HasOne(IO::class, 'id', 'io_id');
    }

    public function diesel()
    {
        return $this->HasOne(IO::class, 'id', 'io_id');
    }

    public function reporte_mensual()
    {
        return $this->HasOne(Reporte_mensual::class, 'id', 'reporte_mensual');
    }
}
