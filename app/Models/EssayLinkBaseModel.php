<?php
namespace App\Models;
use Core\BaseModel;

class EssayLinkBaseModel extends BaseModel {
    protected $table = 'essay_link';

    public function rulesCreate(){
        return [
        ];
    }

    public function rulesUpdate($id){
        return [
        ];
    }

}