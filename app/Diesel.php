<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diesel extends Model
{
    protected $table = 'diesel';

    public function periodo()
    {
    	return $this->HasOne(Periodo::class, 'id', 'periodo');
    }
}
