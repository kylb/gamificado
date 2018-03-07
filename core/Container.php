<?php
namespace Core;

class GenericControler extends BaseController{
    public function __construct() {
        parent::__construct();
    }
}
class Container{
    public static function newController($controller){
        $controller = "App\\Controllers\\" . $controller;
        return new $controller;
    }

    public static function newModel($model){
        $model = "App\\Models\\" . $model;
        return new $model(DataBase::getDatabase());
    }

    public static function pageNotFound(){
        $controler = new GenericControler;
        $controler->renderView("404","layout");
    }
}