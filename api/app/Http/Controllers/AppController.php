<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Conta;
use App\Models\FormasPagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class AppController extends BaseController
{
    public function listarBancos()
    {
        return Banco::all();
        // $bancosCached = Redis::get('bancos');
        // $bancos = [];

        // if (isset($bancosCached)) {
        //     $bancos = \json_decode($bancosCached, FALSE);
        // } else {
        //     $bancos = Banco::all();
        //     Redis::set('bancos', $bancos);
        // }
        // return $bancos;
    }

    public function adicionarBanco(Request $request)
    {
        $this->validate($request, ['codigo' => 'required', 'nome' => 'required']);

        if (Banco::where(['codigo' => $request->input('codigo')])->get()->count()) {
            return response()->json(['erro' => 'Já existe um banco com este código: ' . $request->input('codigo')], 400);
        }

        $banco = new Banco(['codigo' => $request->input('codigo'), 'nome' => $request->input('nome')]);
        $banco->save();

        return response()->json(['sucesso' => 'Banco adicionado com sucesso.'], 201);
    }

    public function excluirBanco(Request $request)
    {
        $this->validate($request, ['id_banco' => 'required']);

        $banco = Banco::where(['id' => $request->input('id_banco')]);
        $banco->delete();

        return response()->json(['sucesso' => 'Banco excluído com sucesso.'], 200);
    }

    public function listarFormasPagamento()
    {
        return FormasPagamento::all();
    }

    public function adicionarFormaPagamento(Request $request)
    {
        $this->validate($request, ['nome' => 'required']);

        if (FormasPagamento::where(['nome' => $request->input('nome')])->get()->count()) {
            return response()->json(['erro' => 'Já existe uma forma de pagamento com este nome: ' . $request->input('nome')], 400);
        }

        $forma_pagamento = new FormasPagamento(['nome' => $request->input('nome')]);
        $forma_pagamento->save();

        return response()->json(['sucesso' => 'Forma de Pagamento adicionada com sucesso.'], 201);
    }

    public function excluirFormaPagamento(Request $request)
    {
        $this->validate($request, ['id_forma_pagamento' => 'required']);

        $forma_pagamento = FormasPagamento::where(['id' => $request->input('id_forma_pagamento')]);
        $forma_pagamento->delete();

        return response()->json(['sucesso' => 'Forma de Pagamento excluída com sucesso.'], 200);
    }

    public function listarHistorico()
    {
        return Conta::select('*', 'contas.id as id_conta', 'bancos.nome as nome_banco')->join('bancos', 'bancos.id', 'id_banco')->join('formas_de_pagamento', 'formas_de_pagamento.id', 'id_forma_pagamento')->get();
    }

    public function adicionarConta(Request $request)
    {
        $this->validate($request, [
            'forma_pagamento' => 'required',
            'banco' => 'required',
            'tipo' => 'required',
            'valor' => 'required',
        ]);

        $conta = new Conta(['id_banco' => $request->input('banco'), 'id_forma_pagamento' => $request->input('forma_pagamento'), 'valor' => $request->input('valor'), 'tipo' => $request->input('tipo')]);
        $conta->save();

        return response()->json(['sucesso' => 'Movimentação adicionada com sucesso.'], 201);
    }

    public function excluirConta(Request $request)
    {
        $this->validate($request, ['id_conta' => 'required']);
        $conta = Conta::where(['id' => $request->input('id_conta')]);
        $conta->delete();

        return response()->json(['sucesso' => 'Movimentação excluída com sucesso.'], 200);
    }

    public function saldo()
    {
        return (new Conta)->saldo();
    }

    public function editarConta(Request $request)
    {
        $this->validate($request, [
            'id_conta' => 'required',
            'tipo' => 'required',
            'valor' => 'required',
        ]);

        $conta = (new Conta())->findOrFail($request->input('id_conta'));
        $conta->valor = $request->input('valor');
        $conta->tipo = $request->input('tipo');
        $conta->save();

        return response()->json(['sucesso' => 'Movimentação atualizada com sucesso.'], 201);
    }
}
