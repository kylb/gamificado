<?php
//Rotas sem autenticação (Públicas) Sem o parâmetro 'auth'
$route[] = ['/',                    'HomeController@index'];
$route[] = ['/painel',              'HomeController@painel',    'auth'];
$route[] = ['/user/create',         'UserController@create'];
$route[] = ['/user/store',          'UserController@store'];
$route[] = ['/user/{id}/edit',      'UserController@edit',      'auth'];
$route[] = ['/user/update',         'UserController@update',    'auth'];

$route[] = ['/user/listar',         'UserController@listar',    'auth'];

$route[] = ['/login',               'UserController@login'];
$route[] = ['/login/auth',          'UserController@auth'];
$route[] = ['/logout',              'UserController@logout',    'auth'];



/*
 * Exemplo de Rotas com acesso privado.
 * Basta adicionar no array um argumento com nome 'auth':
 *
 * $route[] = ['/post/{id}/edit',      'PostsController@edit','auth'];
 * $route[] = ['/post/{id}/update',    'PostsController@update','auth'];
 * $route[] = ['/post/{id}/delete',    'PostsController@delete','auth'];
*/

return $route;
