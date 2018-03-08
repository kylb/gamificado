<?php
namespace App\Models;
use Core\BaseModel;
class User extends BaseModel{
    public $table = 'users';
    public $timestamps = false;
    //protected $fillable = ['name', 'email','password','graduacao','dtnasc','urlfoto','tipo'];

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
            'email' => 'max:100|email|unique:User:email',
            'password' => 'max:60|min:6',
            'graduacao' => 'max:255|min:3',
            'dtnasc' => 'required'
        ];
    }

    /*public function post(){
        return $this->hasMany(Post::class);
    }*/
}