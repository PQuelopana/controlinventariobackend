<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Business extends Model{
    use UsesTenantConnection;
    protected $table = 'business';
    
    public function newObject($paramArr){
        $this->idAccount = $paramArr['idAccount'];
        $this->identityDocumentNumber = $paramArr['identityDocumentNumber'];
        $this->name = $paramArr['name'];
    }
    
    public function editObject($object, $arr){
        
        $arr = [
            $this->table.'.identityDocumentNumber'    => $arr['identityDocumentNumber'],
            $this->table.'.name'                      => $arr['name']
        ];         
        
        return $arr;
    }
}
