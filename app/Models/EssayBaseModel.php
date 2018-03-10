<?php
namespace App\Models;
use Core\BaseModel;

class EssayBaseModel extends BaseModel {
    protected $table = 'essays';

    public function All(){
        $result          = parent::All();
        $user            = new UserBaseModel($this->getPdo());
        $publication     = new PublicationBaseModel($this->getPdo());
        $essayLink       = new EssayLinkBaseModel($this->getPdo());
        $essayAvaliation = new EssayAvaliationBaseModel($this->getPdo());
        $essayOposition  = new EssayOpositionBaseModel($this->getPdo());
        $report          = new ReportBaseModel($this->getPdo());
        foreach ($result as $key => $value){
            $result[$key]->user                      = $user->find($value->id_user);
            $result[$key]->publication               = $publication->find($value->id_publication);
            $result[$key]->essayLink                 = $essayLink->findWhereAll(['id_essay' => $value->id]);
            $result[$key]->essayAvaliation           = $essayAvaliation->findWhereAll(['id_essay' => $value->id]);
            $result[$key]->essayOposition            = $essayOposition->findWhereAll(['id_essay' => $value->id]);
            $result[$key]->report                    = $report->findWhereAll(['id_essay' => $value->id]);
        }
        return $result;
    }

    public function find($id){
        $result = parent::find($id);
        $user            = new UserBaseModel($this->getPdo());
        $publication     = new PublicationBaseModel($this->getPdo());
        $essayLink       = new EssayLinkBaseModel($this->getPdo());
        $essayAvaliation = new EssayAvaliationBaseModel($this->getPdo());
        $essayOposition  = new EssayOpositionBaseModel($this->getPdo());
        $report          = new ReportBaseModel($this->getPdo());
        $value = $result;
        $result->user                      = $user->find($value->id_user);
        $result->publication               = $publication->find($value->id_publication);
        $result->essayLink                 = $essayLink->findWhereAll(['id_essay' => $value->id]);
        $result->essayAvaliation           = $essayAvaliation->findWhereAll(['id_essay' => $value->id]);
        $result->essayOposition            = $essayOposition->findWhereAll(['id_essay' => $value->id]);
        $result->report                    = $report->findWhereAll(['id_essay' => $value->id]);
        return $result;
    }

    public function delete($id) {
        $essayLink = new EssayLinkBaseModel($this->getPdo());
        $essayLink->deleteWhere(['id_essay' => $id]);
        parent::delete($id);
    }
}