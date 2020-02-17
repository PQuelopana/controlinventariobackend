<?php

namespace App\System;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesSystemConnection;


class Account extends Model{
    use UsesSystemConnection;
    protected $table = 'account';
        
    public function newObject($paramArr){
        $this->email = $paramArr['email'];
        $this->password = hash('sha256', $paramArr['password']);
        $this->idHostName = $paramArr['idHostName'];
        $this->codeRestoration = 0;
    }
    
    protected $hidden = [
        'password',
    ];    
    
    public function hostname($object){
        array_push($this->columnsJoin, 'hostnames.fqdn');
        return $object
            ->join('hostnames', $this->table.'.idHostName', '=', 'hostnames.id')
        ;        
    }    
}
