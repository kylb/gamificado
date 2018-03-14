<?php
namespace App\Models;

use Core\BaseModel;

class PublicationBaseModel extends BaseModel {
    protected $table = 'publications';

    public function rulesCreate(){
        return [
            'tema' => 'max:255|min:4',
            'titulo' => 'max:255|min:4'
        ];
    }

    public function rulesUpdate($id){
        return [
            'tema' => 'max:255|min:4',
            'titulo' => 'max:255|min:4'
        ];
    }

    public function findWhereAll(array $conditions){
        $result = parent::findWhereAll($conditions);
        $user  = new UserBaseModel($this->getPdo());
        $essay = new EssayBaseModel($this->getPdo());
        $reference = new ReferenceBaseModel($this->getPdo());
        foreach ($result as $key => $value){
            $result[$key]->user  = $user->find($value->id_user);
            $result[$key]->essay = $essay->findWhereAll(['id_publication' => $value->id]);
            $result[$key]->reference = $reference->findWhereAll(['id_publication' => $value->id]);
        }
        return $result;
    }

    public function find($id){
        $result = parent::find($id);
        $user  = new UserBaseModel($this->getPdo());
        $reference = new ReferenceBaseModel($this->getPdo());
        $result->user  = $user->find($result->id_user);
        $result->reference = $reference->findWhereAll(['id_publication' => $result->id]);
        return $result;
    }

    public function delete($id) {
        $reference = new ReferenceBaseModel($this->getPdo());
        $reference->deleteWhere(['id_publication' => $id]);
        parent::delete($id);
    }

}
