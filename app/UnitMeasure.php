<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class UnitMeasure extends Model{
    use UsesTenantConnection;
    protected $table = 'unit_measure';
    
    public function newObject($paramArr){
        $this->idAccount = $paramArr['idAccount'];
        $this->idOfficial = $paramArr['idOfficial'];
        $this->name = $paramArr['name'];
        $this->abbreviation = $paramArr['abbreviation'];
        $this->indActivated = $paramArr['indActivated'];
    }
    
    public function editObject($object, $arr){
        
        $arr = [
            $this->table.'.idOfficial'    => $arr['idOfficial'],
            $this->table.'.name'          => $arr['name'],
            $this->table.'.abbreviation'  => $arr['abbreviation'],
            $this->table.'.indActivated'  => $arr['indActivated']
        ];      
        
        return $arr;
    }
}
