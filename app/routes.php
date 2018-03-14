<?php
/*
 * Rotas sem autenticação (Públicas) não usar o parâmetro 'auth'
 * Rotas com necessidade de autenticação (privadas) usar o parâmetro 'auth'
 */
$route[] = ['/'                       ,'HomeController@index'];
$route[] = ['/painel'                 ,'HomeController@painel'       ,'auth'];
$route[] = ['/forum'                  ,'ForumController@forum'       ,'auth'];
$route[] = ['/forum/votar'            ,'ForumController@votar'       ,'auth'];
$route[] = ['/forum/{id}/publication' ,'ForumController@publication' ,'auth'];
$route[] = ['/forum/{id}/essay'       ,'ForumController@essay'       ,'auth'];

$route[] = ['/login'                ,'UserController@login'];
$route[] = ['/login/auth'           ,'UserController@auth'];
$route[] = ['/logout'               ,'UserController@logout'    ,'auth'];

$route[] = ['/user/create'          ,'UserController@create'];
$route[] = ['/user/store'           ,'UserController@store'];
$route[] = ['/user/listar'          ,'UserController@listar'    ,'auth'];
$route[] = ['/user/{id}/edit'       ,'UserController@edit'      ,'auth'];
$route[] = ['/user/update'          ,'UserController@update'    ,'auth'];
$route[] = ['/user/{id}/delete'     ,'UserController@delete'    ,'auth'];

$route[] = ['/report/{id}/create'   ,'ReportController@create'  ,'auth'];
$route[] = ['/report/store'         ,'ReportController@store'   ,'auth'];
$route[] = ['/report/listar'        ,'ReportController@listar'  ,'auth'];
$route[] = ['/report/{id}/detalhar' ,'ReportController@detalhar','auth'];
$route[] = ['/report/{id}/delete'   ,'ReportController@delete'  ,'auth'];

$route[] = ['/essay/{id}/create'    ,'EssayController@create'   ,'auth'];
$route[] = ['/essay/store'          ,'EssayController@store'    ,'auth'];
$route[] = ['/essay/listar'         ,'EssayController@listar'   ,'auth'];
$route[] = ['/essay/{id}/edit'      ,'EssayController@edit'     ,'auth'];
$route[] = ['/essay/update'         ,'EssayController@update'   ,'auth'];
$route[] = ['/essay/{id}/detalhar'  ,'EssayController@detalhar' ,'auth'];
$route[] = ['/essay/{id}/delete'    ,'EssayController@delete'   ,'auth'];

$route[] = ['/publication/create'       ,'PublicationController@create'   ,'auth'];
$route[] = ['/publication/store'        ,'PublicationController@store'    ,'auth'];
$route[] = ['/publication/listar'       ,'PublicationController@listar'   ,'auth'];
$route[] = ['/publication/{id}/edit'    ,'PublicationController@edit'     ,'auth'];
$route[] = ['/publication/update'       ,'PublicationController@update'   ,'auth'];
$route[] = ['/publication/{id}/detalhar','PublicationController@detalhar' ,'auth'];
$route[] = ['/publication/{id}/delete'  ,'PublicationController@delete'   ,'auth'];

return $route;
