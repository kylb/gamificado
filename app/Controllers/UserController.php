<?php
namespace App\Controllers;

use App\Models\UserBaseModel;
use Core\Authenticate;
use Core\BaseController;
use Core\Redirect;
use Core\Validator;

require_once (__DIR__ . "/../emailTransport.php");

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
        if(!$this->auth->check()){
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
        if($this->auth->id() != $this->view->user->id && $this->auth->tipo() != 1){
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
        //upload foto
        if ( isset($request->files->urlfoto->name) && $request->files->urlfoto->error == 0 ) {
            $extensao     = strtolower(pathinfo ( $request->files->urlfoto->name, PATHINFO_EXTENSION ));
            $novoNome     = uniqid(time()) . '.' . $extensao;
            $dirUrlFoto      = __DIR__ . '/../../public/assets/img/user/' . $novoNome;
            move_uploaded_file($request->files->urlfoto->tmp_name, $dirUrlFoto);
            $data['urlfoto'] = $novoNome;
        }

        if(Validator::make($data,$this->user->rulesCreate(),$this->user)){
            Redirect::route("/user/create", "layout");
            return;
        }

        $data['password'] = password_hash($request->post->password,PASSWORD_BCRYPT);
        $data['dtnasc'] = implode('-', array_reverse(explode('/', $data['dtnasc'])));

        try{
            $this->user->create($data);
            $transport = \Transport::getTransport();
            $raizEndereco = 'http://localhost:8080';
            $mailer     = new \Swift_Mailer($transport);
            $message    = new \Swift_Message('Forum UFBA - Confirmação de E-mail');
            $message->setFrom(['lemosluan@infojr.com.br' => 'Luan']);
            $message->setTo([$data['email'] => $data['nome']]);
            $message->setBody(
                        'Clique no link abaixo para confirmar o seu e-mail'
                        . $raizEndereco . '/user/validar/' . $this->user->getLastInsertId()
                        . '/' . preg_replace('/[^A-Za-z0-9-]/', '',$data['password'])
            );
            $result = $mailer->send($message);

            Redirect::route('/painel', [
                'success' => ['User created with success. ' . $result]
            ]);

            return;
        }catch(\Exception $e){
            Redirect::route('/', [
                'errors' => [$e->getMessage()]
            ]);
            return;
        }
    }

    public function validar($id,$token){
        $this->view->nome = "Validar E-mail";
        $this->setPageTitle($this->view->nome);
        $user = $this->user->find($id);
        if(preg_replace('/[^A-Za-z0-9-]/', '',$user->password) == $token){
            $data = ['verificado' => 1];
            try{
                $this->user->update($data,$id);
                Redirect::route('/painel', [
                    'success' => ['User updated with success.']
                ]);
                return;
            }catch(\Exception $e){
                Redirect::route('/', [
                    'errors' => [$e->getMessage()]
                ]);
                return;
            }
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

        //upload foto
        if ( isset($request->files->urlfoto->name) && $request->files->urlfoto->error == 0 ) {
            $extensao     = strtolower(pathinfo ( $request->files->urlfoto->name, PATHINFO_EXTENSION ));
            $novoNome     = uniqid(time()) . '.' . $extensao;
            $dirUrlFoto      = __DIR__ . '/../../public/assets/img/user/' . $novoNome;
            move_uploaded_file($request->files->urlfoto->tmp_name, $dirUrlFoto);
            $data['urlfoto'] = $novoNome;
        }

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
        }catch(\Exception $e){
            Redirect::route('/', [
                'errors' => [$e->getMessage()]
            ]);
            return;
        }
    }

    public function listar(){
        $this->view->nome = "Listar Usuários";
        $this->view->acao = 'listar';

        $this->view->users = $this->user->All();

        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("users/listar","layout");
    }

    public function delete($id){
        try{
            if(!$this->auth->check() || $this->auth->tipo() != 1 ){
                Redirect::route('/painel', [
                    'errors' => ['Ahaaa! Você não pode fazer isso.']
                ]);
                return;
            }
            $this->user->delete($id);
            Redirect::route('/user/listar', [
                'success' => ['Usuário inativated with success.']
            ]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', [
                'errors' => [$e->getMessage()]
            ]);
            return;
        }

    }

}
