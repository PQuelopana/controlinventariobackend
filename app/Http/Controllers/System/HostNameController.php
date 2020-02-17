<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hyn\Tenancy\Models\Hostname As ObjectModel;

class HostNameController extends Controller{
    public $object_s;
    public $object_p;
    public $objectName;
    public $objectNameArr;
    
    public function __construct() {
        $this->middleware('api.request.validate', [
            'only' => [
                /*
                 * Cada metodo debe tener una regla definida en config/global
                 * Ejm.: userstoreValidator
                */
                'store', 
                'update',
                'login',
                'passwordRestore'
            ]
        ]);
        
        $this->object_s = 'hostname';
        $this->object_p = 'hostnames';
        $this->objectName = trans('objects.'.$this->object_s);
        $this->objectNameArr = ['object' => $this->objectName];
    }
    
    public function showByfqdn(Request $request, $filter){

        return $this->showControllerByOther(
            $request, ['fqdn' => $filter/*'client1.erpbackend.com.devel'*/], new ObjectModel(), 
            $this->object_p, $this->objectName
        );
        
    }
    
    public function getByfqdn($filter){

        return $this->getObjectByOther(
            ['fqdn' => $filter],
            new ObjectModel()
        )->first();
        
    }
}
