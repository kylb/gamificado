<?php
namespace App\Controllers;
use Core\BaseController;

class HomeController extends BaseController {

    public function index(){
        $this->view->nome = "Home";
        $this->setPageTitle($this->view->nome);
        $this->renderView("home/index","layout");

    }
}