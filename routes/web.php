<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\TurmaController;

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

// rotas sem autenticação
$router->post('/alunos', 'TurmaController@listaAlunos');
$router->post('/professores', 'TurmaController@listaProfessores');
$router->post('/disciplinas', 'TurmaController@listaDisciplinas');
$router->post('/turmas', 'TurmaController@listaTurmas');

// rota com autenticação
$router->post('login', 'LoginController@login');

$router->post('adicionarAluno', 'TurmaController@adicionarAluno');
$router->post('adicionarTurma', 'TurmaController@adicionarTurma');
$router->post('adicionarProfessor', 'TurmaController@adicionarProfessor');
$router->post('adicionarDisciplina', 'TurmaController@adicionarDisciplina');

$router->get('excluirAluno/{id}/{token}', 'TurmaController@excluirAluno');
$router->get('excluirTurma/{id}/{token}', 'TurmaController@excluirTurma');
$router->get('excluirProfessor/{id}/{token}', 'TurmaController@excluirProfessor');
$router->get('excluirDisciplina/{id}/{token}', 'TurmaController@excluirDisciplina');

$router->post('editarAluno', 'TurmaController@editarAluno');
$router->post('editarTurma', 'TurmaController@editarTurma');
$router->post('editarProfessor', 'TurmaController@editarProfessor');
$router->post('editarDisciplina', 'TurmaController@editarDisciplina');