<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Establishment extends Model{
    use UsesTenantConnection;
    protected $table = 'establishment';
    public $indAccount = false;
    
    public function __construct(){
        $this->columnsJoin = [$this->table.'.*'];
    }
    
    public function newObject($paramArr){        
        $this->idBusiness = $paramArr['idBusiness'];
        $this->name = $paramArr['name'];            
    }    
    
    public function editObject($object, $arr){
        
        $arr = [
            $this->table.'.name'              => $arr['name']
        ];         
        
        return $arr;
    }
    
    public function business($object){
        $tableJoin = 'business';
        
        array_push($this->columnsJoin, $tableJoin.'.name As nameBusiness');
        return $object
            ->join($tableJoin, $this->table.'.idBusiness', '=', $tableJoin.'.id')
        ;        
    }
    
    public function objectByIdAccount($objectWhere, $idAccount){
        $object = $this->business($objectWhere);
        
        $object = $object->where('business.idAccount', $idAccount);
        $this->cleanColumnsJoin();
        
        return $object;        
    }
}