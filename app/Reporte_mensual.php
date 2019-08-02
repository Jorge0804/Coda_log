<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reporte_mensual extends Model
{
    protected $table = 'reporte_mensual';
    public $primaryKey = 'id';

    public function cfa_mensual()
    {
    	return $this->HasOne(CFA_mensual::class, 'id', 'cfa_mensual');
    }

    public function cfo_mensual()
    {
    	return $this->HasOne(CFO_mensual::class, 'id', 'cfo_mensual');
    }

    public function cvm_mensual()
    {
    	return $this->HasOne(CVM_mensual::class, 'id', 'cvm_mensual');
    }

    public function cvo_mensual()
    {
    	return $this->HasOne(CVO_mensual::class, 'id', 'cvo_mensual');
    }

    public function io_mensual()
    {
    	return $this->HasOne(IO_mensual::class, 'id', 'io_mensual');
    }

    public function cif_mensual()
    {
        return $this->HasOne(CIF_mensual::class, 'id', 'cif_mensual');
    }

    public function diesel()
    {
    	return $this->HasOne(Diesel::class, 'id', 'diesel');
    }

    public function cf()
    {
        return $this->HasOne(CF::class, 'id', 'cf');
    }

    public function cfa()
    {
        return $this->HasOne(CFA::class, 'id', 'cfa');
    }

    public function cfo()
    {
        return $this->HasOne(CFO::class, 'id', 'cfo');
    }

    public function cvm()
    {
        return $this->HasOne(CVM::class, 'id', 'cvm');
    }

    public function cvo()
    {
        return $this->HasOne(CVO::class, 'id', 'cvo');
    }

    public function io()
    {
        return $this->HasOne(IO::class, 'id', 'io');
    }
}
