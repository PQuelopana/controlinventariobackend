<?php

namespace App\System;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesSystemConnection;

class UnitMeasure extends Model{
    use UsesSystemConnection;
    protected $table = 'unit_measure';        
}
