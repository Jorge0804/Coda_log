<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';
    public $primaryKey = 'id';
    public $timestamps = false;

    public function estado()
    {
    	return $this->HasOne(Estado::class, 'id', 'estado');
    }
}
