<?php
namespace Core;

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
        if(file_exists(__DIR__ . "/../app/Views/404.phtml")){
            return require_once (__DIR__. "/../app/Views/404.phtml");
        } else{
            echo "Error 404 | Page not found. <br />I'm sorry. We are working to improve your most perfect experience. Bye.<br />";
        }
    }
}