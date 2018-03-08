<?php
namespace App\Models;
use Core\BaseModel;

class ReportBaseModel extends BaseModel {
    protected $table = 'reports';

    public function rulesCreate(){
        return [
            'conteudo' => 'max:140|min:4'
        ];
    }

    public function All(){
        $result = parent::All();
        $essay = new EssayBaseModel($this->pdo);
        $user  = new UserBaseModel($this->pdo);
        $reports = new ReportBaseModel($this->pdo);
        foreach ($result as $key => $value){
            $result[$key]->essay = $essay->find($value->id_essay);
            $result[$key]->user  = $user->find($value->id_user);
            $result[$key]->reports = count($reports->findWhereAll(['id_essay' => $value->id_essay]));
        }
        return $result;
    }

    public function find($id){
        $result = parent::find($id);
        $essay = new EssayBaseModel($this->pdo);
        $user  = new UserBaseModel($this->pdo);
        $result->essay = $essay->find($result->id_essay);
        $result->user  = $user->find($result->id_user);
        return $result;
    }
}