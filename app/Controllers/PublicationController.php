<?php
namespace App\Controllers;
use App\Models\PublicationBaseModel;
use App\Models\ReferenceBaseModel;
use Core\BaseController;
use Core\Redirect;
use Core\Validator;

class PublicationController extends BaseController{

    private $publication;

    public function __construct() {
        parent::__construct();
        $this->publication = new PublicationBaseModel();
    }

    public function create(){
        $this->view->nome = "Publications";
        $this->view->acao = 'create';
        if(!$this->auth->check() || $this->auth->tipo() != 1 ){
            Redirect::route('/painel', ['errors' => ['Ahaaa! Você não pode fazer isso.']]);
            return;
        }
        $this->setPageTitle($this->view->nome);
        $this->renderView("publications/_form","layout");
    }

    public function store($request){
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
        if(Validator::make($data,$this->publication->rulesCreate(),$this->publication)){
            Redirect::route("/painel", "layout");
            return;
        }
        $data['id_user'] = $this->auth->id();
        if($data['visivel'] == 1){
            $data['data'] = date('Y-m-d');
        }
        try{
            $this->publication->create($data);
            $idPublication = intval($this->publication->getLastInsertId());
            $reference = new ReferenceBaseModel($this->publication->getPdo());
            foreach ($dataLink as $value){
                if(!empty($value) && $value != ' '){
                    $reference->create(['origem' => $value, 'id_publication' => $idPublication]);
                }
            }
            Redirect::route('/painel', ['success' => ['Publication created with success.']]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', ['errors' => [$e->getMessage()]]);
            return;
        }
    }

    public function listar(){
        $this->view->nome = "Lista Publications";
        $this->view->acao = 'listar';
        $this->view->publication = $this->publication->All();
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("publications/listar","layout");
    }

    public function detalhar($id){
        $this->view->nome = "Detalhe Publication";
        $this->view->acao = 'detalhar';
        $this->view->publication = $this->publication->find($id);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("publications/_form","layout");
    }

    public function delete($id){
        try{
            if(!$this->auth->check() || $this->auth->id() != $this->publication->find($id)->id_user ){
                Redirect::route('/painel', ['errors' => ['Ahaaa! Você não pode fazer isso.']]);
                return;
            }
            $this->publication->delete($id);
            Redirect::route('/publication/listar', ['success' => ['Publication deletado with success.']]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', ['errors' => [$e->getMessage()]]);
            return;
        }
    }

    public function edit($id){
        $this->view->nome = "Edit Publication";
        $this->view->publication = $this->publication->find($id);
        $this->view->acao = 'edit';
        //validacao de acesso indevido a rota de edicao
        if(!$this->auth->check() || $this->auth->id() != $this->view->publication->id_user){
            Redirect::route('/painel', ['errors' => ['Ahaaa! Você não fazer isso!']]);
            return;
        }
        $this->setPageTitle("{$this->view->nome} - {$this->view->publication->titulo}");
        $this->renderView("publications/_form","layout");
    }

    public function update($request){
        $id = $request->post->id;
        $publication = $this->publication->find($id);
        $data = [
            'tema'  => $request->post->tema,
            'titulo' => $request->post->titulo,
            'conteudo' => $request->post->conteudo,
            'visivel' => $request->post->visivel
        ];

        $dataLink = $request->post->origem;

        if(Validator::make($data,$this->publication->rulesUpdate($id),$this->publication)){
            Redirect::route("/publication/{$id}/edit", "layout");
            return;
        }

        if($data['visivel'] == 1 && $publication->visivel != 1){
            $data['data'] = date('Y-m-d');
        }

        try{
            $this->publication->update($data,$id);
            $reference = new ReferenceBaseModel($this->publication->getPdo());
            foreach ($dataLink as $key => $value){
                if($reference->findWhere(['id' => $key, 'id_publication' => $id])){
                    $reference->update(['origem' => $value],$key);
                } else{
                    $reference->create(['origem' => $value, 'id_publication' => $id]);
                }
            }
            Redirect::route('/publication/listar', ['success' => ['User updated with success.']]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', ['errors' => [$e->getMessage()]]);
            return;
        }
    }
}