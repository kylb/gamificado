<?php
namespace App\Models;
use Core\BaseModel;

class ReferenceBaseModel extends BaseModel {
    protected $table = 'publication_references';

    public function rulesCreate(){
        return [
        ];
    }

    public function rulesUpdate($id){
        return [
        ];
    }

}