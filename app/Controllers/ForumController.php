<?php
namespace App\Controllers;
use App\Models\EssayAvaliationBaseModel;
use App\Models\EssayBaseModel;
use App\Models\PublicationBaseModel;
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
        $this->view->acao = 'forum';
        $this->view->publication = $this->publication->findWhereAll(['visivel' => 1]);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("forum/listar","layout");
    }

    public function publication($id){
        $this->view->nome = "Detalhe Publication";
        $this->view->acao = 'detalhar';
        $this->view->publication = $this->publication->find($id);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("forum/publication","layout");
    }

    public function essay($id){
        $this->view->nome = "Detalhe Essay";
        $this->view->acao = 'detalhar';
        $this->view->essay = (new EssayBaseModel($this->publication->getPdo()))->find($id);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("essays/_form","layout");
    }

    public function votar($request){
        $this->view->nome = "Avaliation";
        $this->view->acao = 'votar';
        $avaliation = $_POST['avaliation'];
        $id_essay = $_POST['id_essay'];
        $objAvaliation = new EssayAvaliationBaseModel($this->publication->getPdo());
        if(in_array($avaliation, array(1,-1))){
            $objAvaliation->create([
                'avaliacao' => $avaliation,
                'id_essay' => $id_essay,
                'id_user' => $this->auth->id()
            ]);
        } else if ($avaliation == 0){
            $objAvaliation->deleteWhere([
                'id_essay' => $id_essay,
                'id_user'  => $this->auth->id()
            ]);
        }
    }
}