<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\System\Account As ObjectModel;
use App\Account As ObjectModelClone;
use App\Http\Controllers\UserController;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller{
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
        
        $hostName = $this->getHostNameGeneral();
        
        return $this->storeController(
            $request, new ObjectModel(), $this->object_s, $this->objectNameArr, 
            ['idHostName' => $hostName->id], 
            null, 
            '',
            new ObjectModelClone()
        );
        
    }
    
    public function show($id){
        return $this->showControllerById(
            $id, new ObjectModel(), $this->object_s, $this->objectName,
            ['hostname']
        );
    }
    
    public function getByEmail(Request $request, $email){
        return $this->showControllerByOther(
            $request, ['email' => $email], new ObjectModel(), $this->object_s, $this->objectName, ['hostname']
        );
    }
    
    public function forgotPassword($email){
        $codeRestoration = $this->passwordRestoreGenerateCode($email);
        
        $send = Mail::to($email)->send(new ForgotPassword($codeRestoration));
        
        $data = config('global.dataSuccessMessage');
        $data['message'] = 'Código de Restauración enviado a su correo. Verifique por favor.';
        
        return $this->responseApi($data);
    }
    
    public function passwordRestoreGenerateCode($email) {              
        $objectWhere = ObjectModel::where(['email' => $email]);
        $this->validateObject($objectWhere->first(), $this->objectName, trans('passwords.account'));
        
        $codeRestoration = $this->generateCodeRandom();
            
        $changes = [
            'codeRestoration'  => $codeRestoration
        ];
        $objectWhere->update($changes);

        //$data = array_add(config('global.dataSuccessNoMessage'), 'generatedCode', $generatedCode);
        
        //return $this->responseApi($data);
        
        return $codeRestoration;
    }
    
    public function passwordRestore($email, Request $request) {
        $paramArr = $this->requestJsonDecodeArr($request);
        
        $where = ObjectModel::where('email', $email);
        
        $this->validateObject($where->first(), $this->objectName, trans('passwords.account'));
        
        $where = $where->where('codeRestoration', $paramArr['codeRestoration']);
        
        $this->validateObject($where->first(), $this->objectName, trans('passwords.token'));
        
        $password = hash('sha256', $paramArr['password']);

        $changes = [
            'password'          => $password,
            'codeRestoration'   => 0
        ];
        
        $idAccount = $where->first()->id;
        
        //Actualizando clave de usuarios
        $userController = new UserController();        
        $ok = $userController->passwordRestore($idAccount, $password);
        
        
        $where->update($changes);

        $data = config('global.dataSuccessMessage');
        $data['message'] = trans('passwords.reset');  
        
        return $this->responseApi($data);
    }
}
