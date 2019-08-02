<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resumen extends Model
{
    protected $table = 'resumen';
    protected $id = 'id';
    public $timestamps = false; 

    public function referencia()
    {
    	return $this->BelongsTo(Referencia::class);
    }
}
