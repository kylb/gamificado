<?php
namespace App\Models;
//use Core\BaseModel;
use Core\BaseModelEloquent;
class User extends BaseModelEloquent{
    public $table = 'users';
    public $timestamps = false;
    protected $fillable = ['name', 'email','password'];

    public function rulesCreate(){
        return [
            'name' => 'max:255|min:4',
            'email' => 'max:100|email|unique:User:email',
            'password' => 'max:60|min:6'
        ];
    }
    public function rulesUpdate($id){
        return [
            'name' => 'max:255|min:4',
            'email' => "max:100|email|unique:User:email:{$id}",
            'password' => 'max:60|min:6'
        ];
    }

    public function post(){
        return $this->hasMany(Post::class);
    }
}