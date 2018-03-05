<?php
//Rotas sem autenticação (Públicas) Sem o parâmetro 'auth'
$route[] = ['/',                    'HomeController@index'];
$route[] = ['/user/create',         'UserController@create'];
$route[] = ['/user/store',          'UserController@store'];
//$route[] = ['/user/{id}/update',    'UserController@update']; Rota a implementar
$route[] = ['/login',               'UserController@login'];
$route[] = ['/logout',              'UserController@logout'];
$route[] = ['/login/auth',          'UserController@auth'];


/*
 * Exemplo de Rotas com acesso privado.
 * Basta adicionar no array um argumento com nome 'auth':
 *
 * $route[] = ['/post/{id}/edit',      'PostsController@edit','auth'];
 * $route[] = ['/post/{id}/update',    'PostsController@update','auth'];
 * $route[] = ['/post/{id}/delete',    'PostsController@delete','auth'];
*/

return $route;
