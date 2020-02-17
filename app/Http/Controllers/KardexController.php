<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kardex As ObjectModel;
use App\KardexDetail As ObjectModelDetail;

class KardexController extends Controller{
    public $object_s, $object_p, $objectName, $objectNameArr;
    
    public function __construct() {
        $this->middleware('api.auth', [
            'only' => [
                'store',
                'update',
                'destroy'
            ]
        ]);
        
        $this->middleware('api.request.validate', [
            'only' => [
                /*
                 * Cada metodo debe tener una regla definida en config/global
                 * Ejm.: userstoreValidator
                */
                'store', 
                'update'
            ]
        ]);
        
        $this->object_s = 'kardex';
        $this->object_p = 'kardex';
        $this->objectName = trans('objects.'.$this->object_s);
        $this->objectNameArr = ['object' => $this->objectName];
    }
    
    public function indexByIdBusinessAndType($idBusiness, $type){
        return $this->indexController(
            new ObjectModel(), $this->object_p, ['kardex_motif', 'warehouse', 'establishment'], 
            ['establishment.idBusiness' => $idBusiness, 'kardex_motif.type' => $type]
        );
    }
    
    public function store(Request $request){        
        return $this->storeController(
            $request, new ObjectModel(), $this->object_s, $this->objectNameArr, ['idBusiness' => ''], 
            new ObjectModelDetail(), 'idKardex'
        );
    }
    
    public function update(Request $request, $id){
        return $this->updateController(
            $id, $request, new ObjectModel(), $this->objectName, $this->object_s, $this->objectNameArr, 
            false, new ObjectModelDetail(), 'idKardex', true
        );
    }
    
    public function show(Request $request, $id){
        return $this->showControllerById($request, $id, new ObjectModel(), $this->object_s, $this->objectName);
    }
    
    public function destroy(Request $request, $id){
        return $this->destroyController(
            $id, $request, new ObjectModel(), $this->objectName, $this->object_s, $this->objectNameArr, false, 
            new ObjectModelDetail(), 'idKardex', true
        );
    }
}
