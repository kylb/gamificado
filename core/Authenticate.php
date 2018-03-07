<?php
namespace Core;
trait Authenticate{
    public function login(){
        $this->setPageTitle('Login');
        return $this->renderView('user/login','layout');
    }

    public function auth($request){
        $result = $this->user->findWhere(['email' => $request->post->email]);
        if($result && password_verify($request->post->password, $result->password)){
            $user = [
                'id'            => $result->id,
                'nome'          => $result->nome,
                'email'         => $result->email,
                'graduacao'     => $result->graduacao,
                'dtnasc'        => implode('/', array_reverse(explode('-', $result->dtnasc))),
                'urlfoto'       => $result->urlfoto,
                'pontos'        => $result->pontos,
                'tipo'          => $result->tipo,
                'verificado'    => $result->verificado
                ];
            Session::set('user', $user);
            Redirect::route('/painel');
            return ;
        }

        Redirect::route('/login',[
            'errors' => ['User or Password invalid. Are you sure you are you?'],
            'inputs' => ['email' => $request->post->email]
        ]);
        return;
    }

    public function logout(){
        Session::destroy('user');
        Redirect::route('/login');
        return;
    }
}