<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User As ObjectModel;
use App\Helpers\JwtAuth;

class UserController extends Controller{
    public $object_s, $object_p, $objectName, $objectNameArr;
    
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
        
        $this->object_s = 'account';
        $this->object_p = 'accounts';
        $this->objectName = trans('objects.'.$this->object_s);
        $this->objectNameArr = ['object' => $this->objectName];
    }
    
    public function index(){
        return $this->indexController(new ObjectModel(), $this->object_p);
    }
    
    public function store(Request $request){
        
        return $this->storeController(
            $request, new ObjectModel(), $this->object_s, $this->objectNameArr
        );
        
    }
    
    public function newAccountUser($paramArr) {
        $object = new ObjectModel();
        $object->newObject($paramArr);
        $object->save();
    }
    
    public function login(Request $request){
        $jwtAuth = new JwtAuth();
        $paramArr = $this->requestJsonDecodeArr($request);      
        $password = hash('sha256', $paramArr['password']);
                
        $login = $jwtAuth->loginUser($paramArr['idAccount'], $paramArr['name'], $password);

        $data= array_add(config('global.dataSuccessNoMessage'), 'login', $login);
        
        return $this->responseApi($data);
    }
    
    public function getUserAuth($idAccount, $name, $password){
        $object = ObjectModel::where([
            'idAccount' => $idAccount,
            'name'      => $name,
            'password'  => $password
        ])->first();
        
        //echo $object; die();
        $this->validateObjectAuth($object, $this->objectName);
        
        return $object;
    }
    
    public function getByToken(Request $request){
        $user = $this->getIdentity($request);
        
        $data = array_add(config('global.dataSuccessNoMessage'), 'user', $user);
        
        return $this->responseApi($data);
    }
    
    public function passwordRestore($idAccount, $password) {
        
        $object = ObjectModel::where('idAccount', $idAccount);
        
        /*
        Mas adelante cuando exista opcion de cambiar contraseña a usuario
        $this->validateObject($where->first(), $this->objectName, trans('passwords.account'));
        $where = $where->where('codeRestoration', $paramArr['codeRestoration']);
        $this->validateObject($where->first(), $this->objectName, trans('passwords.token'));
        $pwd = hash('sha256', $paramArr['password']);
        */                                

        $changes = [
            'password'          => $password
        ];
        
        
        $object->update($changes);

        //$data = config('global.dataSuccessMessage');
        //$data['message'] = trans('passwords.reset');  
        
        //return $this->responseApi($data);
        return true;
    }
}
