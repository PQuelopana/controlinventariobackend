<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class Kardex extends Model{
    use UsesTenantConnection;
    protected $table = 'kardex';
    public $indBusiness = false;
    
    public function __construct(){
        $this->columnsJoin = [$this->table.'.*'];
    }
    
    public function newObject($paramArr){
        $this->idWarehouse = $paramArr['idWarehouse'];
        $this->idKardexMotif = $paramArr['idKardexMotif'];        
        $this->date = $paramArr['date'];
        $this->hour = $paramArr['hour'];
        $this->idInternal = $this->getNewIdInternalByWarehouse($this->idWarehouse);
    }    
    
    public function editObject($object, $arr){
        
        $arr = [
            $this->table.'.idWarehouse'   => $arr['idWarehouse'],
            $this->table.'.idKardexMotif' => $arr['idKardexMotif'],
            $this->table.'.date'          => $arr['date'],
            $this->table.'.hour'          => $arr['hour']
        ];         
        
        if($object->idWarehouse !== $arr['idWarehouse']){
            $arr['idInternal'] = $this->getNewIdInternalByWarehouse($arr['idWarehouse']);
        }
        
        return $arr;
    }
    
    private function getNewIdInternalByWarehouse($idWarehouse){
        $kardex = $this::where(['idWarehouse' => $idWarehouse])->orderBy('idInternal', 'desc')->first('idInternal');
        
        if(is_object($kardex)){
            $data = $kardex->idInternal + 1;
        }else{
            $data = 1;
        }
        
        return $data;
    }
    
    public function kardex_motif($object){
        $tableJoin = 'kardex_motif';
        
        array_push($this->columnsJoin, $tableJoin.'.name As nameKardexMotif');
        return $object
            ->join($tableJoin, $this->table.'.idKardexMotif', '=', $tableJoin.'.id')
        ;        
    }       
    
    public function warehouse($object){
        $tableJoin = 'warehouse';
        
        array_push($this->columnsJoin, $tableJoin.'.name As nameWarehouse');
        return $object
            ->join($tableJoin, $this->table.'.idWarehouse', '=', $tableJoin.'.id')
        ;        
    }
    
    public function establishment($object){
        $tableJoin = 'establishment';
        
        array_push($this->columnsJoin, $tableJoin.'.name As nameEstablishment');
        return $object
            ->join($tableJoin, 'warehouse.idEstablishment', '=', $tableJoin.'.id')
        ;        
    }
    
    public function getByIdAndIdBusiness($id, $idBusiness){
        $object = $this::where($this->table.'.id', $id);
        $object = $this->warehouse($object);
        $object = $this->establishment($object);
        $object = $object->where('establishment.idBusiness', $idBusiness);
        
        $this->cleanColumnsJoin();
        
        return $object;        
    }
    
    public function objectByIdBusiness($objectWhere, $idBusiness){        
        $object = $this->warehouse($objectWhere);
        $object = $this->establishment($objectWhere);
        $object = $object->where('establishment.idBusiness', $idBusiness);
        
        $this->cleanColumnsJoin();
        
        return $object;        
    }
}
