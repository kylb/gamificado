<?php
namespace App\Models;
use Core\BaseModelEloquent;

class UserBaseModelEloquent extends BaseModelEloquent {
    public $table = 'users';
    public $timestamps = false;
    protected $fillable = ['name', 'email','password','graduacao','dtnasc','urlfoto','tipo','verificado'];

    public function rulesCreate(){
        return [
            'name' => 'max:255|min:4',
            'email' => 'max:100|email|unique:User:email',
            'password' => 'max:60|min:6',
            'graduacao' => 'max:255|min:3',
            'dtnasc' => 'required'
        ];
    }
    public function rulesUpdate($id){
        return [
            'name' => 'max:255|min:4',
            'email' => "max:100|email|unique:User:email:{$id}",
            'password' => 'max:60|min:6',
            'graduacao' => 'max:255|min:3',
            'dtnasc' => 'required'
        ];
    }

    /*public function post(){
        return $this->hasMany(Post::class);
    }*/
}