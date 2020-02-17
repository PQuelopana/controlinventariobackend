<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\System\UnitMeasure As ObjectModel;
use App\UnitMeasure As ObjectModelClient;

class UnitMeasureController extends Controller{
    public function getAll(){
        return $this->getAllController(
            new ObjectModel()
        );
    }
    
    public function newAccount($idAccount) {
        
        $this->newAccountController($idAccount, new ObjectModel(), new ObjectModelClient());
        
    }
}
