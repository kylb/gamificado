<?php
namespace App\Controllers;
use App\Models\EssayBaseModel;
use App\Models\EssayLinkBaseModel;
use App\Models\EssayOpositionBaseModel;
use App\Models\PublicationBaseModel;
use Core\BaseController;
use Core\Redirect;
use Core\Validator;

class EssayController extends BaseController{

    private $essay;

    public function __construct() {
        parent::__construct();
        $this->essay = new EssayBaseModel;
    }

    public function create($id){
        $this->view->nome = "Criar essays";
        $this->view->acao = 'create';
        $publication = new PublicationBaseModel($this->essay->getPdo());
        $this->view->essay->publication = $publication->find($id);
        if(!$this->auth->check()){
            Redirect::route('/painel', ['errors' => ['Ahaaa! Você não pode fazer isso.']]);
            return;
        }
        $this->setPageTitle($this->view->nome);
        $this->renderView("essays/_form","layout");
    }

    public function store($request){
        if(!$this->auth->check()){
            Redirect::route('/painel', ['errors' => ['Ahaaa! Você não pode fazer isso.']]);
            return;
        }
        $data = [
            'titulo' => $request->post->titulo,
            'conteudo' => $request->post->conteudo,
            'posicao' => $request->post->posicao,
            'id_publication' => $request->post->id_publication,
            'id_user' => $this->auth->id()
        ];

        if(Validator::make($data,$this->essay->rulesCreate(),$this->essay)){
            Redirect::route("/painel", "layout");
            return;
        }

        try{
            $this->essay->create($data);
            $idEssay = intval($this->essay->getLastInsertId());
            $essayLink = new EssayLinkBaseModel($this->essay->getPdo());

            $dataLink = $request->post->url;
            foreach ($dataLink as $value){
                if(!empty($value) && $value != ' '){
                    $essayLink->create(['url' => $value, 'id_essay' => $idEssay]);
                }
            }

            $idEssayOposition = $request->post->id;
            if(!empty($idEssayOposition) && $idEssayOposition != 0 && $idEssayOposition != ' '){
                $essayOposition = new EssayOpositionBaseModel($this->essay->getPdo());
                $essayOposition->create(['id_essay' => $idEssay, 'id_essay_oposition' => $idEssayOposition]);
            }
            Redirect::route('/forum/'. $data['id_publication'] . '/publication', ['success' => ['essay created with success.']]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', ['errors' => [$e->getMessage()]]);
            return;
        }
    }

    public function listar(){
        $this->view->nome = "Lista essays";
        $this->view->acao = 'listar';
        $this->view->essay = $this->essay->findWhereAll(['id_user' => $this->auth->id()]);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("essays/listar","layout");
    }

    public function detalhar($id){
        $this->view->nome = "Detalhe essay";
        $this->view->acao = 'detalhar';
        $this->view->essay = $this->essay->find($id);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("essays/_form","layout");
    }

    public function delete($id){
        try{
            if(!$this->auth->check() || $this->auth->id() != $this->essay->find($id)->id_user){
                Redirect::route('/painel', ['errors' => ['Ahaaa! Você não pode fazer isso.']]);
                return;
            }
            $this->essay->delete($id);
            Redirect::route('/essay/listar', ['success' => ['Essay deletado with success.']]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', ['errors' => [$e->getMessage()]]);
            return;
        }
    }

    public function edit($id){
        $this->view->nome = "Edit essay";
        $this->view->essay = $this->essay->find($id);
        $this->view->acao = 'edit';
        if(!$this->auth->check() || $this->auth->id() != $this->view->essay->id_user){
            Redirect::route('/painel', ['errors' => ['Ahaaa! Você não fazer isso!']]);
            return;
        }
        $this->setPageTitle("{$this->view->nome} - {$this->view->essay->titulo}");
        $this->renderView("essays/_form","layout");
    }

    public function update($request){
        $id = $request->post->id;
        $data = [
            'titulo'         => $request->post->titulo,
            'conteudo'       => $request->post->conteudo,
            'posicao'        => $request->post->posicao,
            'id_publication' => $request->post->id_publication
        ];
        $dataLink = $request->post->url;

        if(Validator::make($data,$this->essay->rulesUpdate($id),$this->essay)){
            Redirect::route("/essay/{$id}/edit", "layout");
            return;
        }

        try{
            $this->essay->update($data,$id);
            $essayLink = new EssayLinkBaseModel($this->essay->getPdo());
            foreach ($dataLink as $key => $value){
                if($essayLink->findWhere(['id' => $key, 'id_essay' => $id])){
                    $essayLink->update(['url' => $value],$key);
                } else{
                    $essayLink->create(['url' => $value, 'id_essay' => $id]);
                }
            }
            Redirect::route('/essay/listar', ['success' => ['Essay updated with success.']]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', ['errors' => [$e->getMessage()]]);
            return;
        }
    }
}