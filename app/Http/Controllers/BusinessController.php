<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business As ObjectModel;

class BusinessController extends Controller{
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
        
        $this->object_s = 'business';
        $this->object_p = 'business';
        $this->objectName = trans('objects.'.$this->object_s);
        $this->objectNameArr = ['object' => $this->objectName];
    }
    
    public function indexByIdAccount($idAccount){
        return $this->indexController(new ObjectModel(), $this->object_p, '', ['idAccount' => $idAccount]);
    }
    
    public function store(Request $request){        
        return $this->storeController(
            $request, new ObjectModel(), $this->object_s, $this->objectNameArr, ['idAccount' => '']
        );        
    }
    
    public function update(Request $request, $id){
        return $this->updateController(
            $id, $request, new ObjectModel(), $this->objectName, $this->object_s, $this->objectNameArr, 
            true
        );
    }
    
    public function show(Request $request, $id){
        return $this->showControllerById($request, $id, new ObjectModel(), $this->object_s, $this->objectName);
    }
    
    public function destroy(Request $request, $id){
        return $this->destroyController($id, $request, new ObjectModel(), $this->objectName, $this->object_s, $this->objectNameArr, true);
    }
    
    public function newAccount($idAccount) {
        $objectModel = new ObjectModel();
        
        $paramArr['idAccount'] = $idAccount;
        $paramArr['identityDocumentNumber'] = '11111111111';
        $paramArr['name'] = 'Empresa 1';
        
        $objectModel->newObject($paramArr);
        $objectModel->save();
        
        return $objectModel->id;
    }
}