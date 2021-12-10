<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\Professor;
use App\Models\Usuario;

class TurmaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function listaAlunos()
    {
        return Aluno::all();
    }
    public function listaProfessores()
    {
        return Professor::all();
    }
    public function listaDisciplinas()
    {
        return Disciplina::all();
    }
    public function listaTurmas()
    {
        return Turma::all();
    }

    public function adicionarAluno()
    {
        $data = request();

        $aluno = new Aluno();
        $aluno->nome = $data->input('nome');
        $aluno->idade = $data->input('idade');
        $aluno->dt_nascimento = $data->input('dt_nascimento');
        $aluno->save();
        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function adicionarTurma()
    {
        $data = request();

        $aluno = new Turma();
        $aluno->titulo = $data->input('titulo');
        $aluno->sala = $data->input('sala');
        $aluno->save();
        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function adicionarProfessor()
    {
        $data = request();

        $aluno = new Professor();
        $aluno->nome = $data->input('nome');
        $aluno->titulacao = $data->input('titulacao');
        $aluno->save();
        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function adicionarDisciplina()
    {
        $data = request();

        $aluno = new Disciplina();
        $aluno->titulo = $data->input('titulo');
        $aluno->save();
        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function excluirTurma($id, $token)
    {
        $this->checkToken($token);

        $aluno = Turma::where(['id' => $id]);
        $aluno->delete();

        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }
    public function excluirDisciplina($id, $token)
    {
        $this->checkToken($token);

        $aluno = Disciplina::where(['id' => $id]);
        $aluno->delete();

        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }
    public function excluirProfessor($id, $token)
    {
        $this->checkToken($token);

        $aluno = Professor::where(['id' => $id]);
        $aluno->delete();

        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function excluirAluno($id, $token)
    {
        $this->checkToken($token);

        $aluno = Aluno::where(['id' => $id]);
        $aluno->delete();

        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function editarTurma()
    {
        $data = request();
        $turma = Turma::where(['id' => $data->input('id')])->first();
        $turma->titulo = $data->input('titulo');
        $turma->sala = $data->input('sala');
        $turma->save();

        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function editarAluno()
    {
        $data = request();

        $aluno = Aluno::where(['id' => $data->input('id')])->first();
        $aluno->nome = $data->input('nome');
        $aluno->idade = $data->input('idade');
        $aluno->dt_nascimento = $data->input('dt_nascimento');
        $aluno->save();
        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function editarProfessor()
    {
        $data = request();

        $aluno = Professor::where(['id' => $data->input('id')])->first();
        $aluno->nome = $data->input('nome');
        $aluno->titulacao = $data->input('titulacao');
        $aluno->save();
        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    public function editarDisciplina()
    {
        $data = request();

        $aluno = Disciplina::where(['id' => $data->input('id')])->first();
        $aluno->titulo = $data->input('titulo');
        $aluno->save();
        return redirect()->to(url(env('FRONTEND_URL') . '/auth/autenticado.php'));
    }

    private function checkToken($token)
    {
        $usuario = Usuario::where(['token' => $token])->first();
        if ($usuario != null) {
            return true;
        }
        exit('Sem permissão');
    }
    //
}
