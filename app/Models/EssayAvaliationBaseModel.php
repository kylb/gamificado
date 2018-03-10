<?php
namespace App\Models;
use Core\BaseModel;

class EssayAvaliationBaseModel extends BaseModel {
    protected $table = 'essay_avaliation';

    public function rulesCreate(){
        return [
        ];
    }

    public function rulesUpdate($id){
        return [
        ];
    }

}