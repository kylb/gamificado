<?php
namespace App\Models;

use Core\BaseModel;

class EssayBaseModel extends BaseModel {
    protected $table = 'essays';

    //sobrescrita de método para trazer dados tabelas vinculadas
    public function find($id){
        $result = parent::find($id);

        $publication  = new PublicantionBaseModel($this->getPdo());
        $result->publication = $publication->find($result->id_publication);

        $user  = new UserBaseModel($this->getPdo());
        $result->user = $user->find($result->id_user);

        return $result;
    }

}
