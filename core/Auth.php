<?php
namespace Core;
class Auth{
    private static $id = null;
    private static $nome = null;
    private static $email = null;
    private static $graduacao = null;
    private static $dtnasc = null;
    private static $urlfoto = null;
    private static $pontos = null;
    private static $tipo = null;
    private static $verificado = null;

/*    private static $publications = null;
    private static $essays = null;
    private static $reports = null;
    private static $votes = null;*/

    public function __construct(){
        if(Session::get('user')){
            $user = Session::get('user');
            self::$id         = $user['id'];
            self::$nome       = $user['nome'];
            self::$email      = $user['email'];
            self::$graduacao  = $user['graduacao'];
            self::$dtnasc     = $user['dtnasc'];
            self::$urlfoto    = $user['urlfoto'];
            self::$pontos     = $user['pontos'];
            self::$tipo       = $user['tipo'];
            self::$verificado = $user['verificado'];

            /*self::$publications = $user['publications'];
            self::$essays       = $user['essays'];
            self::$reports      = $user['reports'];
            self::$votes        = $user['reports'];*/
        }
    }
    public static function id(){
        return self::$id;
    }
    public static function nome(){
        return self::$nome;
    }
    public static function email(){
        return self::$email;
    }
    public static function graduacao(){
        return self::$graduacao;
    }
    public static function dtnasc(){
        return self::$dtnasc;
    }
    public static function urlfoto(){
        return self::$urlfoto;
    }
    public static function pontos(){
        return self::$pontos;
    }
    public static function tipo(){
        return self::$tipo;
    }
    public static function verificado(){
        return self::$verificado;
    }
    /*public static function publications(){
        return self::$publications;
    }
    public static function essays(){
        return self::$essays;
    }
    public static function reports(){
        return self::$reports;
    }
    public static function votes(){
        return self::$votes;
    }*/



    public static function check(){
        if(self::$id == null || self::$nome == null || self::$email == null)
            return false;
        return true;
    }
}