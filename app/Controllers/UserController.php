<?php
namespace App\Controllers;

use App\Models\User;
use Core\BaseController;
use Core\Redirect;
use Core\Validator;
use Core\Authenticate;

class UserController extends BaseController {

    use Authenticate;

    private $user;

    public function __construct() {
        parent::__construct();
        $this->user = new User;
    }

    public function create(){
        $this->view->nome = "New User";
        $this->setPageTitle($this->view->nome);
        $this->renderView("users/create","layout");
    }

    public function login(){
        $this->view->nome = "Login Panel";
        $this->setPageTitle($this->view->nome);
        $this->renderView("users/login","layout");
    }

    public function store($request){
        $data = [
            'name' => $request->post->name,
            'email' => $request->post->email,
            'password' => $request->post->password
        ];

        if(Validator::make($data,$this->user->rulesCreate())){
            return Redirect::route("/user/create", "layout");
        }

        $data['password'] = password_hash($request->post->password,PASSWORD_BCRYPT);

        try{
            $this->user->create($data);
            Redirect::route('/', [
                'success' => ['User created with success.']
            ]);
        }catch(\Exception $e){
            Redirect::route('/', [
                'errors' => [$e->getMessage()]
            ]);
        }
    }
}
