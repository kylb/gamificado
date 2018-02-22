<?php
namespace App\Controllers;
use App\Models\Category;
use App\Models\Post;
use Core\Auth;
use Core\BaseController;
use Core\Redirect;
use Core\Validator;

class PostsController extends BaseController
{
    private $post;

    public function __construct() {
        parent::__construct();
        $this->post = new Post;
    }

    public function index(){
        $this->view->nome = "Posts";
        $this->setPageTitle($this->view->nome);
        $this->view->posts = $this->post->all();
        $this->renderView("posts/index","layout");
    }

    public function show($id){
        $this->view->nome = "Post";
        $this->view->post = $this->post->find($id);
        $this->setPageTitle("{$this->view->post->title}");
        $this->renderView("posts/show","layout");
    }

    public function create(){
        $this->view->nome = "New Post";
        $this->setPageTitle($this->view->nome);
        $this->view->categories = Category::all();
        $this->renderView("posts/create","layout");
    }

    public function edit($id){
        $this->view->nome = "Edit Post";
        $this->view->post = $this->post->find($id);
        $this->view->categories = Category::all();
        //validacao de acesso indevido a rota de edicao
        if(Auth::id() != $this->view->post->user->id){
            return Redirect::route('/posts', [
                'errors' => ['Ahaaa! Você não pode editar posts de outro autor.']
            ]);
        }
        $this->setPageTitle("{$this->view->nome} - {$this->view->post->title}");
        $this->renderView("posts/edit","layout");
    }

    public function store($request){
        $data = [
            'user_id' => Auth::id(),
            'title' => $request->post->title,
            'content' => $request->post->content
        ];
        if(Validator::make($data,$this->post->rulesCreate())){
            return Redirect::route("/post/create");
        }
        try{
            $this->view->post = $this->post->create($data);
            if(isset($request->post->category_id)){
                $this->view->post->category()->sync($request->post->category_id);
            }
            return Redirect::route('/posts', [
                'success' => ['Post created with success.']
            ]);
        }catch(\Exception $e){
            return Redirect::route('/posts', [
                'errors' => [$e->getMessage()]
            ]);
        }
    }

    public function update($id,$request){
        $data = [
            'title' => $request->post->title,
            'content' => $request->post->content
        ];
        if(Validator::make($data,$this->post->rulesUpdate())){
            return Redirect::route("/post/{$id}/edit");
        }
        try{
            $this->view->post = $this->post->find($id);
            $this->view->post->update($data);
            if(isset($request->post->category_id)){
                $this->view->post->category()->sync($request->post->category_id);
            } else{
                $this->view->post->category()->detach();
            }
            return Redirect::route('/posts', [
                'success' => ['Post edited with success.']
            ]);
        }catch(\Exception $e){
            return Redirect::route('/posts', [
                'errors' => [$e->getMessage()]
            ]);
        }
    }

    public function delete($id){
        try{
            $this->view->post = $this->post->find($id);
            if(Auth::id() != $this->view->post->user->id){
                return Redirect::route('/posts', [
                    'errors' => ['Ahaaa! Você não pode deletar posts de outro autor.']
                ]);
            }
            $this->view->post->delete();
            $this->view->post->category()->detach();
            return Redirect::route('/posts', [
                'success' => ['Post deleted with success.']
            ]);
        }catch(\Exception $e){
            return Redirect::route('/posts', [
                'errors' => [$e->getMessage()]
            ]);
        }
    }
}
