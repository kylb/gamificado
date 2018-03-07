<?php
namespace App\Controllers;

//use App\Models\User;
//use Core\DataBase;
use App\Models\UserBaseModel;
use Core\BaseController;
use Core\Redirect;
use Core\Validator;
use Core\Authenticate;
use Core\Auth;

class UserController extends BaseController {

    use Authenticate;

    private $user;

    public function __construct() {
        parent::__construct();
        $this->user = new UserBaseModel;
    }

    public function create(){
        $this->view->nome = "Cadastro de Usuários";
        $this->view->acao = 'create';
        $this->setPageTitle($this->view->nome);
        $this->renderView("users/_form","layout");
    }

    public function login(){
        $this->view->nome = "Painel de Login";
        $this->setPageTitle($this->view->nome);
        if(!Auth::check()){
            $this->renderView("users/login","layout");
            return;
        } else{
            Redirect::route('/painel', [
                'errors' => ['Você já está logado.']
            ]);
            return;
        }
    }

    public function edit($id){
        $this->view->nome = "Edit User";
        $this->view->user = $this->user->find($id);
        $this->view->acao = 'edit';
        //validacao de acesso indevido a rota de edicao de usuario
        if(Auth::id() != $this->view->user->id && Auth::tipo() != 1){
            Redirect::route('/painel', [
                'errors' => ['Ahaaa! Você não pode editar usuário de outra pessoa.']
            ]);
            return;
        }
        $this->setPageTitle("{$this->view->nome} - {$this->view->user->nome}");
        $this->renderView("users/_form","layout");
    }

    public function store($request){
        $data = [
            'nome'      => $request->post->nome,
            'email'     => $request->post->email,
            'graduacao' => $request->post->graduacao,
            'dtnasc'    => $request->post->dtnasc,
            'password'  => $request->post->password,
            'tipo'      => $request->post->tipo
        ];

        if(Validator::make($data,$this->user->rulesCreate(),$this->user)){
            Redirect::route("/user/create", "layout");
            return;
        }

        $data['password'] = password_hash($request->post->password,PASSWORD_BCRYPT);
        $data['dtnasc'] = implode('-', array_reverse(explode('/', $data['dtnasc'])));

        try{
            $this->user->create($data);
            Redirect::route('/login', [
                'success' => ['User created with success.']
            ]);
            return;
        }catch(Exception $e){
            Redirect::route('/', [
                'errors' => [$e->getMessage()]
            ]);
            return;
        }
    }

    public function update($request){
        $id = $request->post->id;
        $data = [
            'nome'      => $request->post->nome,
            'email'     => $request->post->email,
            'graduacao' => $request->post->graduacao,
            'dtnasc'    => $request->post->dtnasc,
            'tipo'      => $request->post->tipo
        ];

        if(Validator::make($data,$this->user->rulesUpdate($id),$this->user)){
            Redirect::route("/user/{$id}/edit", "layout");
            return;
        }

        if ($request->post->password != ' ' && !empty($request->post->password)) {
            $data['password'] = password_hash($request->post->password,PASSWORD_BCRYPT);
        }

        $data['dtnasc'] = implode('-', array_reverse(explode('/', $data['dtnasc'])));

        try{
            $this->user->update($data,$id);
            Redirect::route('/painel', [
                'success' => ['User updated with success.']
            ]);
            return;
        }catch(Exception $e){
            Redirect::route('/', [
                'errors' => [$e->getMessage()]
            ]);
            return;
        }
    }
}
