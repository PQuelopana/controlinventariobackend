<?php

namespace App\Http\Middleware;

use Closure;

class ApiRequestValidateMiddleware extends \App\Helpers\GlobalF{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        //var_dump($request->getRouteResolver()); die();
        
        $paramArr = $this->requestJsonDecodeArr($request);
        
        if(!empty($paramArr)){
            $objectAction = $this->getObjectAndActionOfRequest($request);
            
            $rules = config('global.'.$objectAction.'Validator');
            
            /*
             * Para:
             * Exceptuar el Código de Cuenta en las Reglas Unicas.
             * Agregar condición en Regla única.
            */            
            $rules = $this->ruleConfig($rules, $request);
                        
            $validate = \Validator::make($paramArr, $rules);
            
            if($validate->fails()){
                $data = config('global.dataErrorValidate');
                $data['errors'] = $validate->errors();                
            }
            
            if(array_key_exists('details', $paramArr)){
                $index = 0;
                
                $rules = config('global.'.$objectAction.'detailvalidator');
                
                $rules = $this->ruleConfig($rules, $request);
                
                $paramDetailArr = $paramArr['details'];
                foreach ($paramDetailArr as $detail){
                    $validate = \Validator::make($detail, $rules);
            
                    if($validate->fails()){
                        if(!isset($data)){
                            $data = config('global.dataErrorValidate');
                        }
                        $errorsArr = ['Item' => $index + 1] + json_decode($validate->errors(), true);
                        
                        $data['errorsDetail'][$index] = $errorsArr;
                    }
                    
                    $index++;
                }                
            }
        }else{
            $data = config('global.dataErrorRequest');
        }
        
        if(!isset($data)){
            return $next($request);
        }else{
            return $this->responseHttpExceptionApi($data);
        }        
    }
}
