<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class KardexDetail extends Model{
    use UsesTenantConnection;
    protected $table = 'kardex_detail';
    public $timestamps = false;
    
    public function __construct(){
        $this->columnsJoin = [$this->table.'.*'];
    }
    
    public function newObject($paramArr){
        $this->idKardex = $paramArr['idKardex'];
        $this->item = $paramArr['item'];
        $this->idProduct = $paramArr['idProduct'];
        $this->quantity = $paramArr['quantity'];
        $this->unitPrice = $paramArr['unitPrice'];
        $this->totalPrice = $paramArr['totalPrice'];
    }    
    
    public function product($object){
        $tableJoin = 'product';
        
        array_push($this->columnsJoin, $tableJoin.'.name As nameProduct');
        return $object
            ->join($tableJoin, $this->table.'.idProduct', '=', $tableJoin.'.id')
        ;        
    }
    
    public function unit_measure($object){
        $tableJoin = 'unit_measure';
        
        array_push($this->columnsJoin, $tableJoin.'.abbreviation As abbreviationUnitMeasure');
        return $object
            ->join($tableJoin, 'product.idUnitMeasure', '=', $tableJoin.'.id')
        ;        
    }
}
