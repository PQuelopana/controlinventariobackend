<?php

namespace App;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class User extends Model /*extends Authenticatable*/{
    //use Notifiable;
    use UsesTenantConnection;
    protected $table = 'user';
    
    public function newObject($paramArr){
        $this->idAccount = $paramArr['idAccount'];
        $this->name = $paramArr['name'];
        $this->password = hash('sha256', $paramArr['password']);
    }
    
    /*protected $fillable = [
        'name', 'email', 'password',
    ];
    */
    
    protected $hidden = [
        'password',
    ];
}
