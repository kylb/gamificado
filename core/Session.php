<?php
namespace Core;

class Session{
    public static function set($key,$value){
        $_SESSION[$key] = $value;
    }

    public static function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return false;
    }

    public static function destroy($keys){
        if(is_array($keys)){
            foreach ($keys as $key){
                unset($_SESSION[$key]);
            }
        } else{
            unset($_SESSION[$keys]);
        }
    }
}