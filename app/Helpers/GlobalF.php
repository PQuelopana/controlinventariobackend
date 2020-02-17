<?php
namespace App\Helpers;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\System\AccountController;
use App\Http\Controllers\System\HostNameController;
use App\Http\Controllers\System\UnitMeasureController;
use App\Http\Controllers\System\KardexMotifController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\WarehouseController;

use App\Http\Controllers\UserController;
use App\Helpers\JwtAuth;
use Illuminate\Validation\Rule;

class GlobalF{
    
    public function __construct(){
    }
    
    public function validateObject($object, $objectName, $message = '', $key = ''){
        $this->validateObjectConstruct($object, $objectName, 'dataErrorNotFound', $message, $key);
    }
    
    public function validateObjectAuth($object, $objectName){
        $this->validateObjectConstruct($object, $objectName, 'dataErrorAuth');
    }
    
    public function validateObjectConstruct($object, $objectName, $configGlobal, $message = '', $key = ''){
        
        //if(!is_object($object) || (!key_exists($key, $object) && $key != '')){
        if(!is_object($object)){
            $data = config('global.'.$configGlobal);
            if($message == ''){
                $data['message'] = str_replace(':object', $objectName, $data['message']);
                $data['message'] = str_replace(':key', trans('objects.'.$key), $data['message']);
            }else{
                $data['message'] = $message;
            }
        }
        
        if(isset($data)) $this->responseHttpExceptionApi($data);
    }
    
    public function requestJsonDecodeArr($request){
        $json = $request->input('json', null);
        
        if(!is_null($json)){
            $paramArr = json_decode($json, true);            
            if(!is_array($paramArr)){
                //$paramArr = array_map('trim', $paramArr);
            //}else{
                $data = config('global.dataErrorRequest');
                $data['message'] = trans('messages.json');
                $this->responseHttpExceptionApi($data);
            }
        }else{
            $paramArr = null;
        }
        
        return $paramArr;
    }
    
    public function responseApi($data){
        return response()->json($data, $data['code']);
    }
    
    public function responseHttpExceptionApi($data){
        throw new HttpResponseException(response()->json($data, $data['code']));
    }
    
    public function getIdentity($request){
        $jwtAuth = new JwtAuth();
        
        $token = $this->getTokenFromRequest($request);
        
        $user = $jwtAuth->checkToken($token, true);
        
        return $user;
    }
    
    public function getTokenFromRequest($request){
        return $this->getOfAuthorizationFromRequest($request, 'token');
    }
    
    public function getOfAuthorizationFromRequest($request, $get){
        $authorization = $request->header('Authorization', null);
        
        if(!is_null($authorization)){
            $authorization = json_decode($authorization, true);           
            if(!is_array($authorization)){
                $authorization = null;
            }
        }else{
            $authorization = null;
        }                
        
        if(is_null($authorization)){
            $data = null;
        }else{
            if(array_key_exists($get, $authorization)){
                $data = $authorization[$get];
            }else{
                $data = null;
            }                
        }
        
        return $data;
    }
    
    public function getIdBusinessFromRequest($request){
        return $this->getOfAuthorizationFromRequest($request, 'idBusiness');
    }
    
    public function getObjectAndActionOfRequest($request){
        $objectAction = Route::getCurrentRoute()->getActionName();
        
        $slash = strrpos($objectAction, '\\');
        if($slash > 0){
            $objectAction = strtolower(str_replace('Controller', '', substr($objectAction, $slash + 1, strlen($objectAction))));
        }        
        
        return str_replace('@', '', $objectAction);
    }        
    
    public function generateCodeRandom(){
        return mt_rand(1, 9999);
    }
    
    public function getAccountAuth($email, $password){
        $accountController = new AccountController();
        return $accountController->getAccountAuth($email, $password);
    }
    
    public function getUserAuth($idAccount, $name, $password){
        $userController = new UserController();
        return $userController->getUserAuth($idAccount, $name, $password);
    }
    
    public function getHostNameGeneral(){
        $hostNameController = new HostNameController();
        return $hostNameController->getByfqdn('client1.erpbackend.com.devel');
    }
    
    public function saveTablesNewAccount($idAccount){
        $unitMeasureController = new UnitMeasureController();
        $unitMeasureController->newAccount($idAccount);
                
        $kardexMotifController = new KardexMotifController();
        $kardexMotifController->newAccount($idAccount);
        
        $businessController = new BusinessController();
        $idBusiness = $businessController->newAccount($idAccount);
        
        $establishmentController = new EstablishmentController();
        $idEstablishment = $establishmentController->newAccount($idBusiness);
        
        $warehouseController = new WarehouseController();
        $warehouseController->newAccount($idEstablishment);
    }
    
    public function storeNewUser($paramArr){
        $userController = new UserController();
        $userController->newAccountUser($paramArr);
    }
    
    public function ruleConfig($rules, $request){
        
        if($rules == ''){
            $data = config('global.dataErrorNotFound');
            $data['message'] = 'Configurar Reglas de Validación.';
            
            return $this->responseHttpExceptionApi($data);
        }
        
        foreach($rules as $key => $value) {
            if(is_array($rules[$key])){
                foreach($rules[$key] as $key2 => $value2) {
                    
                    $ruleOri = $rules[$key][$key2];
                    
                    //echo $ruleOri.'-----';
                    $rules[$key][$key2] = $this->ruleUniqueAddConditions($rules[$key][$key2], $request);
                    //echo $rules[$key][$key2]; die();
                    
                    $rules[$key][$key2] = $this->ruleUniqueAddIgnore($rules[$key][$key2], $ruleOri, $request);
                }
            //}else{
            //    $rules[$key] = $this->ruleReplaceField($rules[$key], $request);                
            }
        }
        
        return $rules;
    }    
    
    public function ruleUniqueAddConditions($rule, $request){
        
        $pos = strpos($rule, 'unique&');
        if($pos !== false){
            $posSF = strpos($rule, '&') + 1;
            $posEF = strpos($rule, ':') - $posSF;
            $field = substr($rule, $posSF, $posEF);

            $posST = strpos($rule, ':') + 1;
            $posET = strpos($rule, '/') - $posST;
            $table = substr($rule, $posST, $posET);
            
            $rule = Rule::unique($table)->where(function ($query) use($request, $field) {
                
                if($field == 'idAccount'){
                    $idField = $this->getIdentity($request)->$field;
                }else if($field == 'idBusiness'){
                    $idField = $this->getIdBusinessFromRequest($request);                   
                }else{
                    $paramArr = $this->requestJsonDecodeArr($request);
                    $idField = $paramArr[$field];
                }
                
                return $query->where($field, $idField);
            });
            
            //$rule = $rule->ignore(25);
            
        }
        
        return $rule;
    }
    
    public function ruleUniqueAddIgnore($rule, $ruleOri, $request){
        
        $pos = strpos($ruleOri, 'ignore#');
        if($pos !== false){
            $posSF = strpos($ruleOri, '#') + 1;
            $posEF = strlen($ruleOri) - $posSF + 1;
            $field = substr($ruleOri, $posSF, $posEF);

            if($field == 'idRequest'){
                $path = $request->path();
                
                $posSIF = strripos($path, '/') + 1;
                $posEIF = strlen($path) - $posSIF + 1;
                $idField = substr($path, $posSIF, $posEIF);
                
                //echo $idField; die();
            }
            
            $rule = $rule->ignore($idField);
        }
        
        return $rule;
    }
   
}