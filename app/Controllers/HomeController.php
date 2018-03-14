<?php
namespace App\Controllers;
use App\Models\EssayAvaliationBaseModel;
use App\Models\EssayBaseModel;
use App\Models\PublicationBaseModel;
use App\Models\ReportBaseModel;
use App\Models\UserBaseModel;
use Core\BaseController;
use Core\Session;

class HomeController extends BaseController {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->view->nome = "Home";
        $this->setPageTitle($this->view->nome);
        $this->renderView("home/index","layout");
    }

    public function painel(){
        $this->view->nome = "Painel";
        $this->setPageTitle($this->view->nome);
        $this->userStatus();
        $this->renderView("home/painel","layout");
    }

    private function userStatus(){
        $objUser = new UserBaseModel;

        $publication     = new PublicationBaseModel($objUser->getPdo());
        $essay           = new EssayBaseModel($objUser->getPdo());
        $essayAvaliation = new EssayAvaliationBaseModel($objUser->getPdo());
        $report          = new ReportBaseModel($objUser->getPdo());

        $this->view->essay           = $essay->findWhereAll(['id_user' => $this->auth->id()]);
        $this->view->publication     = $publication->findWhereAll(['id_user' => $this->auth->id()]);
        $this->view->essayAvaliation = $essayAvaliation->findWhereAll(['id_user' => $this->auth->id()]);
        $this->view->report          = $report->findWhereAll(['id_user' => $this->auth->id()]);
        $pontos = 0;

        foreach ($this->view->essay as $essay){
            foreach ($essay->essayAvaliation as $value){
                $pontos += (int) $value->avaliacao;
            }
        }

        $userStatus = [
            'pontos'            => $pontos,
            'essays'            => count($this->view->essay),
            'publications'      => count($this->view->publication),
            'essayAvaliations'  => count($this->view->essayAvaliation),
            'reports'           => count($this->view->report)
        ];
        Session::set('status',$userStatus);
    }
}