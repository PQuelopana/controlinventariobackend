<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\JwtAuth;
use App\Helpers\GlobalF;

class ApiAuthMiddleware extends GlobalF{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        //Comprobar si el usuario está identificado
        $token = $this->getTokenFromRequest($request);// $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);
        
        if($checkToken){
            return $next($request);
        }else{
            $data = array(
                'code'      => 400,
                'message'   => trans('auth.noIdentity')
            );
            
            return response()->json($data, $data['code']);
        }
    }
}
