<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'v1'], function($router) {

    $router->post('/adicionarbanco', 'AppController@adicionarBanco');
    $router->post('/listarbancos', 'AppController@listarBancos');
    $router->post('/excluirbanco', 'AppController@excluirBanco');

    $router->post('/listarformaspagamento', 'AppController@listarFormasPagamento');
    $router->post('/adicionarformapagamento', 'AppController@adicionarFormaPagamento');
    $router->post('/excluirformapagamento', 'AppController@excluirFormaPagamento');

    $router->post('/listarhistorico', 'AppController@listarHistorico');
    $router->post('/adicionarconta', 'AppController@adicionarConta');
    $router->post('/editarconta', 'AppController@editarConta');
    $router->post('/excluirconta', 'AppController@excluirConta');
    $router->post('/saldo', 'AppController@saldo');

    $router->post('/autenticado', 'AuthController@autenticado');
});

$router->post('/login', 'AuthController@login');
$router->post('/registrar', 'AuthController@registrar');
