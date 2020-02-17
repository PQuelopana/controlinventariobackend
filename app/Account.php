<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Account extends Model{
    
    use UsesTenantConnection;
    protected $table = 'account';
    
    public function newObject($paramArr){
        $this->id = $paramArr['id'];
        $this->email = $paramArr['email'];
    }
    
    protected $hidden = [
        'password',
    ];
}
