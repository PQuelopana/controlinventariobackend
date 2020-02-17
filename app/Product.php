<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Product extends Model{
    use UsesTenantConnection;
    protected $table = 'product';
    public $indAccount = false;
    
    public function __construct(){
        $this->columnsJoin = [$this->table.'.*'];
    }
    
    public function newObject($paramArr){        
        $this->idBusiness = $paramArr['idBusiness'];
        $this->idInternal = $paramArr['idInternal'];
        $this->name = $paramArr['name'];
        $this->idUnitMeasure = $paramArr['idUnitMeasure'];
        $this->stockMinimun = $paramArr['stockMinimun'];             
    }    
    
    public function editObject($object, $arr){
        
        $arr = [
            $this->table.'.idInternal'    => $arr['idInternal'],
            $this->table.'.name'          => $arr['name'],
            $this->table.'.idUnitMeasure' => $arr['idUnitMeasure'],
            $this->table.'.stockMinimun'  => $arr['stockMinimun']
        ];         
        
        return $arr;
    }
    
    public function unit_measure($object){
        array_push($this->columnsJoin, 'unit_measure.abbreviation As abbreviationUnitMeasure');
        return $object
            ->join('unit_measure', 'product.idUnitMeasure', '=', 'unit_measure.id')
        ;        
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