<?php
namespace App\Models;

use Core\BaseModelEloquent;

class Category extends BaseModelEloquent {
    public $table = 'categories';
    public $timestamps = false;
    protected $fillable = ['name', 'description'];

    public function rulesCreate(){
        return [
            'name' => 'max:50|min:3',
            'description' => 'max:255|min:10'
        ];
    }

    public function rulesUpdate(){
        return [
            'name' => 'max:50|min:3',
            'description' => 'max:255|min:10'
        ];
    }

    public function post(){
        return $this->belongsToMany(Post::class);
    }

}