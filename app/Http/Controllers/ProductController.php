<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product As ObjectModel;

class ProductController extends Controller{
    public $object_s, $object_p, $objectName, $objectNameArr;
    
    public function __construct() {
        $this->middleware('api.auth', [
            'only' => [
                'store',
                'update',
                'destroy',
                'show'
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
        
        $this->object_s = 'product';
        $this->object_p = 'products';
        $this->objectName = trans('objects.'.$this->object_s);
        $this->objectNameArr = ['object' => $this->objectName];
    }
    
    public function indexByIdBusiness($idBusiness){
        return $this->indexController(
            new ObjectModel(), $this->object_p, ['unit_measure'], ['idBusiness' => $idBusiness]
        );
    }
    
    public function store(Request $request){        
        return $this->storeController(
            $request, new ObjectModel(), $this->object_s, $this->objectNameArr, ['idBusiness' => '']
        );        
    }
    
    public function update(Request $request, $id){
        return $this->updateController(
            $id, $request, new ObjectModel(), $this->objectName, $this->object_s, $this->objectNameArr, 
            false, null, '', true
        );
    }
    
    public function show(Request $request, $id){
        return $this->showControllerById(
            $request, $id, new ObjectModel(), $this->object_s, $this->objectName, ['unit_measure'], true, true
        );
    }
    
    public function destroy(Request $request, $id){
        return $this->destroyController(
            $id, $request, new ObjectModel(), $this->objectName, $this->object_s, $this->objectNameArr, false, null, '',
            true
        );
    }
}
