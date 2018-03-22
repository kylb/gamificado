<?php
namespace App\Models;
use Core\BaseModel;

class ConfigBaseModel extends BaseModel {
    protected $table = 'config';

    public function rulesCreate(){
        return [
        ];
    }

    public function rulesUpdate($id){
        return [
        ];
    }

}