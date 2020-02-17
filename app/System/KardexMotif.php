<?php

namespace App\System;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesSystemConnection;

class KardexMotif extends Model{
    use UsesSystemConnection;
    protected $table = 'kardex_motif';
}
