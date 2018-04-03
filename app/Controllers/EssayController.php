<?php
namespace App\Controllers;
use App\Models\EssayBaseModel;
use Core\BaseController;
use Core\Redirect;
use Core\Validator;

class EssayController extends BaseController{

    private $essay;

    public function __construct() {
        parent::__construct();
        $this->essay = new EssayBaseModel;
    }

    public function create(){
        $this->view->nome = "essays";
        $this->view->acao = 'create';
        if(!$this->auth->check() || $this->auth->tipo() != 1 ){
            Redirect::route('/painel', ['errors' => ['Ahaaa! Você não pode fazer isso.']]);
            return;
        }
        $this->setPageTitle($this->view->nome);
        $this->renderView("essays/_form","layout");
    }

  /*  public function store($request){
        if(!$this->auth->check() || $this->auth->tipo() != 1 ){
            Redirect::route('/painel', ['errors' => ['Ahaaa! Você não pode fazer isso.']]);
            return;
        }
        $data = [
            'tema'  => $request->post->tema,
            'titulo' => $request->post->titulo,
            'conteudo' => $request->post->conteudo,
            'visivel' => $request->post->visivel
        ];
        $dataLink = $request->post->origem;
        if(Validator::make($data,$this->essay->rulesCreate(),$this->essay)){
            Redirect::route("/painel", "layout");
            return;
        }
        $data['id_user'] = $this->auth->id();
        if($data['visivel'] == 1){
            $data['data'] = date('Y-m-d');
        }
        try{
            $this->essay->create($data);
            $idessay = intval($this->essay->getLastInsertId());
            $reference = new ReferenceBaseModel($this->essay->getPdo());
            foreach ($dataLink as $value){
                if(!empty($value) && $value != ' '){
                    $reference->create(['origem' => $value, 'id_essay' => $idessay]);
                }
            }
            Redirect::route('/painel', ['success' => ['essay created with success.']]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', ['errors' => [$e->getMessage()]]);
            return;
        }*/
    }

    public function listar(){
        $this->view->nome = "Lista essays";
        $this->view->acao = 'listar';
        $this->view->essay = $this->essay->All();
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
            if(!$this->auth->check() || $this->auth->id() != $this->essay->find($id)->id_user ){
                Redirect::route('/painel', ['errors' => ['Ahaaa! Você não pode fazer isso.']]);
                return;
            }
            $this->essay->delete($id);
            Redirect::route('/essay/listar', ['success' => ['essay deletado with success.']]);
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
        //validacao de acesso indevido a rota de edicao
        if(!$this->auth->check() || $this->auth->id() != $this->view->essay->id_user){
            Redirect::route('/painel', ['errors' => ['Ahaaa! Você não fazer isso!']]);
            return;
        }
        $this->setPageTitle("{$this->view->nome} - {$this->view->essay->titulo}");
        $this->renderView("essays/_form","layout");
    }

    /*public function update($request){
        $id = $request->post->id;
        $essay = $this->essay->find($id);
        $data = [
            'tema'  => $request->post->tema,
            'titulo' => $request->post->titulo,
            'conteudo' => $request->post->conteudo,
            'visivel' => $request->post->visivel
        ];

        $dataLink = $request->post->origem;

        if(Validator::make($data,$this->essay->rulesUpdate($id),$this->essay)){
            Redirect::route("/essay/{$id}/edit", "layout");
            return;
        }

        if($data['visivel'] == 1 && $essay->visivel != 1){
            $data['data'] = date('Y-m-d');
        }

        try{
            $this->essay->update($data,$id);
            $reference = new ReferenceBaseModel($this->essay->getPdo());
            foreach ($dataLink as $key => $value){
                if($reference->findWhere(['id' => $key, 'id_essay' => $id])){
                    $reference->update(['origem' => $value],$key);
                } else{
                    $reference->create(['origem' => $value, 'id_essay' => $id]);
                }
            }
            Redirect::route('/essay/listar', ['success' => ['User updated with success.']]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', ['errors' => [$e->getMessage()]]);
            return;
        }
    }*/
    
}