<?php

class Transport{

    public static function getTransport(){
        $transport  = new \Swift_SmtpTransport('smtp.gmail.com',465,'ssl');
        $transport->setUsername('lemosluan@infojr.com.br');
        $transport->setPassword('Ku$h*135');
        return $transport;
    }
}
