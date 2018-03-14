<?php
namespace App\Models;
use Core\BaseModel;

class UserBaseModel extends BaseModel{
    protected $table = 'users';

    public function rulesCreate(){
        return [
            'nome' => 'max:255|min:4',
            'email' => 'max:100|email|unique:UserBaseModel:email',
            'password' => 'max:60|min:6',
            'graduacao' => 'max:255|min:3',
            'dtnasc' => 'date'
        ];
    }

    public function rulesUpdate($id){
        return [
            'nome' => 'max:255|min:4',
            'email' => 'max:100|email|unique:UserBaseModel:email:' . $id,
            'graduacao' => 'max:255|min:3',
            'dtnasc' => 'date'
        ];
    }
}