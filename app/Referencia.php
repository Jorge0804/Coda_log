<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    protected $table = 'referencias';
    protected $id = 'id';
    public $timestamps = false; 

    public function Resumen()
    {
    	return $this->hasone(Resumen::class, 'id', 'resumen');
    }
}
