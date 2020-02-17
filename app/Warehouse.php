<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Warehouse extends Model{
    use UsesTenantConnection;
    protected $table = 'warehouse';    
    public $indAccount = false;
    public $indBusiness = false;
    
    public function __construct(){
        $this->columnsJoin = [$this->table.'.*'];
    }
    
    public function newObject($paramArr){
        $this->idEstablishment = $paramArr['idEstablishment'];
        $this->name = $paramArr['name'];
    }    
    
    public function editObject($object, $arr){
        
        $arr = [
            $this->table.'.idEstablishment'   => $arr['idEstablishment'],
            $this->table.'.name'              => $arr['name']
        ];         
        
        return $arr;
    }
    
    public function establishment($object){
        $tableJoin = 'establishment';
        
        array_push($this->columnsJoin, $tableJoin.'.name As nameEstablishment');
        return $object
            ->join($tableJoin, $this->table.'.idEstablishment', '=', $tableJoin.'.id')
        ;        
    }       
    
    public function business($object){
        $tableJoin = 'business';
        
        array_push($this->columnsJoin, $tableJoin.'.name As nameBusiness');
        return $object
            ->join($tableJoin, 'establishment.idBusiness', '=', $tableJoin.'.id')
        ;        
    }  
    
    public function getByIdAndIdBusiness($id, $idBusiness){
        $object = $this::where($this->table.'.id', $id);
        $object = $this->establishment($object);
        $object = $object->where('establishment.idBusiness', $idBusiness);
        
        $this->cleanColumnsJoin();
        
        return $object;        
    }
    
    public function objectByIdBusiness($objectWhere, $idBusiness){        
        $object = $this->establishment($objectWhere);
        $object = $object->where('establishment.idBusiness', $idBusiness);
        
        $this->cleanColumnsJoin();
        
        return $object;        
    }
    
    public function objectByIdAccount($objectWhere, $idAccount){        
        $object = $this->establishment($objectWhere);
        $object = $this->business($objectWhere);
        $object = $object->where('business.idAccount', $idAccount);
        
        $this->cleanColumnsJoin();
        
        return $object;        
    }
}
