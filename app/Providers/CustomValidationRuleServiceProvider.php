<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class CustomValidationRuleServiceProvider extends ServiceProvider{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(){
        Validator::extend('is_alpha_num', function($attribute, $value, $parameters){
            return $this->is_alpha_num($attribute, $value, $parameters);
        });
    }
    
    public function is_alpha_num($attribute, $value, $parameters){
        $strFound = false;
        $intFound = false;

        for($x = 0; $x < strlen($value); $x++){// Recorremos cada caracter de la cadena
            if(!$strFound) $strFound = !is_numeric(substr($value, $x, 1));// Si aún no encontramos un caracter no numérico lo buscamos
            if(!$intFound) $intFound = is_numeric(substr($value, $x, 1));// Si aún no encontramos un caracter numérico lo buscamos
            if($strFound && $intFound) break;
        }

        return $strFound && $intFound;
    }
}
