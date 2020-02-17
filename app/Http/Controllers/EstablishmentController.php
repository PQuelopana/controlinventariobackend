<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Establishment As ObjectModel;

class EstablishmentController extends Controller{
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
        
        $this->object_s = 'establishment';
        $this->object_p = 'establishments';
        $this->objectName = trans('objects.'.$this->object_s);
        $this->objectNameArr = ['object' => $this->objectName];
    }
    
    public function indexByIdBusiness($idBusiness){
        return $this->indexController(
            new ObjectModel(), $this->object_p, '', ['idBusiness' => $idBusiness]
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
            true, null, '', true
        );
    }
    
    public function show(Request $request, $id){
        return $this->showControllerById(
            $request, $id, new ObjectModel(), $this->object_s, $this->objectName, '', true, true
        );
    }
    
    public function destroy(Request $request, $id){
        return $this->destroyController(
            $id, $request, new ObjectModel(), $this->objectName, $this->object_s, $this->objectNameArr, false, null, '',
            true
        );
    }
    
    public function newAccount($idBusiness) {
        $objectModel = new ObjectModel();
        
        $paramArr['idBusiness'] = $idBusiness;
        $paramArr['name'] = 'Principal';
        
        $objectModel->newObject($paramArr);
        $objectModel->save();
        
        return $objectModel->id;
    }
}
