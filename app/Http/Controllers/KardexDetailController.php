<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\KardexDetail As ObjectModel;

class KardexDetailController extends Controller{
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
        
        $this->object_s = 'kardexdetail';
        $this->object_p = 'kardexdetails';
        $this->objectName = trans('objects.'.$this->object_s);
        $this->objectNameArr = ['object' => $this->objectName];
    }
    
    public function indexByIdKardex($idKardex){
        $objectModel = new ObjectModel();
        
        return $this->indexController(
            $objectModel, $this->object_p, ['product', 'unit_measure'], 
            [$objectModel->getTable().'.idkardex' => $idKardex]
        );
    }
    /*
    public function show(Request $request, $id){
        return $this->showControllerById($request, $id, new ObjectModel(), $this->object_s, $this->objectName);
    }
    */    
}
