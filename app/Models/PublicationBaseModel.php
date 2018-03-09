<?php
namespace App\Models;

use Core\BaseModel;

class PublicationBaseModel extends BaseModel {
    protected $table = 'publications';

    //sobrescrita de método para trazer dados tabelas vinculadas
    public function find($id){
        $result = parent::find($id);
        $user  = new UserBaseModel($this->getPdo());
        $result->user = $user->find($result->id_user);
        return $result;
    }

}