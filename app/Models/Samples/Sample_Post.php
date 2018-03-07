<?php
namespace App\Models;
//use Core\BaseModel;
use Core\BaseModelEloquent;
class Post extends BaseModelEloquent {
    public $table = 'posts';
    public $timestamps = false;
    protected $fillable = ['user_id', 'title', 'content'];

    public function rulesCreate(){
        return [
            'title' => 'max:255|min:5',
            'content' => 'max:2000|min:10'
        ];
    }

    public function rulesUpdate(){
        return [
            'title' => 'max:255|min:5',
            'content' => 'max:2000|min:10'
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsToMany(Category::class);
    }
}