<?php
namespace Core;

use App\Models\User;

trait AuthenticateBaseModelEloquent{
    public function login(){
        $this->setPageTitle('Login');
        return $this->renderView('user/login','layout');
    }

    public function auth($request){
        $result = User::where('email',$request->post->email)->first();
        if($result && password_verify($request->post->password, $result->password)){
            $user = [
                'id' => $result->id,
                'name' => $result->name,
                'email' => $result->email
                ];
            Session::set('user', $user);
            return Redirect::route('/');
        }

        return Redirect::route('/login',[
            'errors' => ['User or Password invalid. Are you sure you are you?'],
            'inputs' => ['email' => $request->post->email]
        ]);
    }

    public function logout(){
        Session::destroy('user');
        return Redirect::route('/login');
    }
}