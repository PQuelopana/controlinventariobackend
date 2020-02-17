<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class KardexMotif extends Model{
    use UsesTenantConnection;
    protected $table = 'kardex_motif';
    
    public function newObject($paramArr){
        $this->idAccount = $paramArr['idAccount'];
        $this->type = $paramArr['type'];
        $this->name = $paramArr['name'];
    }
    
    public function editObject($object, $arr){
        
        $arr = [
            $this->table.'.type'  => $arr['type'],
            $this->table.'.name'  => $arr['name']
        ];         
        
        return $arr;
    }
}
