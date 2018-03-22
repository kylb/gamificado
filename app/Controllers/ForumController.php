<?php
namespace App\Controllers;
use App\Models\EssayAvaliationBaseModel;
use App\Models\EssayBaseModel;
use App\Models\PublicationBaseModel;
use App\Models\UserBaseModel;
use Core\BaseController;
use Core\Redirect;

class ForumController extends BaseController{

    private $publication;

    public function __construct() {
        parent::__construct();
        $this->publication = new PublicationBaseModel;
    }

    public function forum(){
        $this->view->nome = "Forum";
        $this->view->acao = 'index';
        $this->view->publication = $this->publication->findWhereAll(['visivel' => 1]);
        $objEssay = new EssayBaseModel($this->publication->getPdo());
        usort($this->view->publication,function ($a,$b){return $a->data < $b->data;});
        foreach($this->view->publication as $key => $value){
            $this->view->publication[$key]->essay = $objEssay->findWhereAll(['id_publication' => $value->id]);
        }
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("forum/index","layout");
    }

    public function publication($id){
        $this->view->nome = "Forum";
        $this->view->acao = 'detalhar';
        $this->view->publication = $this->publication->find($id);
        $objEssay = new EssayBaseModel($this->publication->getPdo());
        $this->view->publication->essay = $objEssay->findWhereAll(['id_publication' => $this->view->publication->id]);
        foreach($this->view->publication->essay as $key => $value){
            $this->view->publication->essay[$key]->essayInOposition = $objEssay->find($value->essayInOposition);
        }
        $this->publication->update(['clicks' => $this->view->publication->clicks + 1],$id);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("forum/publication","layout");
    }

    public function contrapor($id){
        $this->view->nome = "Forum";
        $this->view->acao = 'contrapor';
        $this->view->essay = (new EssayBaseModel($this->publication->getPdo()))->find($id);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("forum/contrapor","layout");
    }

    public function votar($request){
        $this->view->nome = "Forum";
        $this->view->acao = 'votar';
        $avaliation = $request->post->avaliation;
        $id_essay = $request->post->id_essay;
        $objAvaliation  = new EssayAvaliationBaseModel($this->publication->getPdo());
        $objUser        = new UserBaseModel($this->publication->getPdo());
        $idUserEssay    = (new EssayBaseModel($this->publication->getPdo()))->find($id_essay)->id_user;
        $pontos = $objUser->find($idUserEssay)->pontos;
        if(in_array($avaliation, array(1,-1))){
            $objAvaliation->create([
                'avaliacao' => $avaliation,
                'id_essay' => $id_essay,
                'id_user' => $this->auth->id()
            ]);
            $pontos = $pontos + $avaliation;
            $objUser->update(['pontos' => $pontos], $idUserEssay);
        } else if ($avaliation == 0){
            $pontos = $pontos - $objAvaliation->findWhere([
                    'id_essay' => $id_essay,
                    'id_user'  => $this->auth->id()
                ])->avaliacao;
            $objUser->update(['pontos' => $pontos], $idUserEssay);
            $objAvaliation->deleteWhere([
                'id_essay' => $id_essay,
                'id_user'  => $this->auth->id()
            ]);
        }
    }
}