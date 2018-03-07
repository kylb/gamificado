<?php
namespace Core;

abstract class BaseController{
    private $viewPath;
    private $layoutPath;
    private $pageTitle = null;
    protected $view;
    protected $auth;
    protected $poweredBy;
    protected $errors;
    protected $success;
    protected $inputs;

    public function __construct(){
        $this->view = new \stdClass;
        $this->auth = new Auth;
        $this->poweredBy = "InfoJr UFBA";
        if(Session::get('success')){
            $this->success = Session::get('success');
            Session::destroy('success');
        }
        if(Session::get('errors')){
            $this->errors = Session::get('errors');
            Session::destroy('errors');
        }
        if(Session::get('inputs')){
            $this->inputs = Session::get('inputs');
            Session::destroy('inputs');
        }
    }

    public function renderView($viewPath,$layoutPath = null){
        $this->viewPath = $viewPath;
        $this->layoutPath = $layoutPath;
        if($layoutPath){
            $this->layout();
        }else{
            $this->content();
        }
    }

    protected function content(){
        if(file_exists( __DIR__ . "/../app/Views/{$this->viewPath}.phtml")){
            return require_once (__DIR__ . "/../app/Views/{$this->viewPath}.phtml");
        } else{
            echo  "View Path not found.";
        }
    }

    protected function layout(){
        if(file_exists( __DIR__ . "/../app/Views/{$this->layoutPath}.phtml")){
            return require_once (__DIR__ . "/../app/Views/{$this->layoutPath}.phtml");
        } else{
            echo  "Layout Path not found.";
        }
    }

    protected function setPageTitle($pageTitle){
        $this->pageTitle = $pageTitle;
    }

    protected function getPageTitle($separator = null){
        if($separator){
            return  $this->pageTitle . " $separator ";
        } else{
            return  $this->pageTitle;
        }
    }

    public function forbiden(){
        Redirect::route("/login");
    }

}