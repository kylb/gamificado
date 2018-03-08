<?php
/*
 * Rotas sem autenticação (Públicas) não usar o parâmetro 'auth'
 * Rotas com necessidade de autenticação (privadas) usar o parâmetro 'auth'
 */
$route[] = ['/'                     ,'HomeController@index'];
$route[] = ['/painel'               ,'HomeController@painel'        ,'auth'];

$route[] = ['/login'                ,'UserController@login'];
$route[] = ['/login/auth'           ,'UserController@auth'];
$route[] = ['/logout'               ,'UserController@logout'        ,'auth'];

$route[] = ['/user/create'          ,'UserController@create'];
$route[] = ['/user/store'           ,'UserController@store'];
$route[] = ['/user/{id}/edit'       ,'UserController@edit'          ,'auth'];
$route[] = ['/user/update'          ,'UserController@update'        ,'auth'];
$route[] = ['/user/{id}/delete'     ,'UserController@delete'        ,'auth'];
$route[] = ['/user/listar'          ,'UserController@listar'        ,'auth'];

$route[] = ['/report/listar'        ,'ReportController@listar'      ,'auth'];
$route[] = ['/report/{id}/detalhar' ,'ReportController@detalhar'    ,'auth'];
$route[] = ['/report/{id}/delete'   ,'ReportController@delete'      ,'auth'];

$route[] = ['/essay/{id}/detalhar'  ,'EssayController@detalhar'     ,'auth'];

return $route;
