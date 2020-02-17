<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Iluminate\Suport\Facades\DB;

class JwtAuth extends GlobalF{
    public $key;
    public $globalF;
    
    public function __construct(){
        $this->key = '54544dv4ddf6gfg65e466r34345rg+-s';
    }
    
    public function loginUser($idAccount, $name, $password){        
        //Buscar si existe el usuario con sus credenciales
        $user = $this->getUserAuth($idAccount, $name, $password);
        //echo $user; die();
        //Generar el token con los datos del usuario identificado
        $signup = [
            'id'                        => $user->id,
            'idAccount'                 => $user->idAccount,
            'name'                      => $user->name,
            'iat'                       => time(),
            'exp'                       => time() + (7 * 24 * 60 * 60) //Una semana de duracion
        ];

        //$token = JWT::encode($signup, $this->key, 'HS256');
        $token = \Firebase\JWT\JWT::encode($signup, $this->key, 'HS256');
        
        /*
        if(!$getToken){
            $data = $jwt;
        }else{
            $data = $token;
        }
        */
        
        $data = $signup;
        $data['token'] = $token;
        
        return $data;         
    }
    
    public function checkToken($jwt, $getIdentity = false){
        $auth = false;
        
        try{
            $jwt = str_replace('"', '', $jwt);            
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $e) {            
            $decoded = 'Token expirado o incorrecto';
        } catch (\DomainException $e){            
            $decoded = 'Token expirado o incorrecto';
        }
        
        if(!empty($decoded) && is_object($decoded) && isset($decoded->id)) $auth = true;
        
        if($getIdentity){
            $data = $decoded;
        }else{
            $data = $auth;
        }
        
        return $data;            
    }
}