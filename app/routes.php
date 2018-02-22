<?php

$route[] = ['/',                    'HomeController@index'];
$route[] = ['/user/create',         'UserController@create'];
$route[] = ['/user/store',          'UserController@store'];
//$route[] = ['/user/{id}/update',    'UserController@update']; Rota a implementar
$route[] = ['/login',               'UserController@login'];
$route[] = ['/logout',              'UserController@logout'];
$route[] = ['/login/auth',          'UserController@auth'];

return $route;
