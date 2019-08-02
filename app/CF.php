<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CF extends Model
{
    protected $table = 'costos_financiamiento';
    public $primaryKey = 'id';
    public $timestamps = false;
}
