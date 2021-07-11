<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use App\Indicacao;
use App\StatusIndicacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * class IndicacaoController
 */
class IndicacaoController extends Controller
{        
    /**
     * Cadastro de indicações
     *
     * @param  mixed $request
     * @return void
     */
    public function cadastrar(Request $request)
    {
        $dados = $request->all();

        $dados['cpf'] = Utils::removeMascara($dados['cpf']);

        $validator = Validator::make($dados, [
            'nome' => 'required',
            'cpf' => 'required|cpf|unique:indicacoes,cpf',
            'telefone' => 'required|celular_com_ddd',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->messages(), 
                'status' => 403
            ], 200);
        }

        $dados['telefone'] = Utils::removeMascara($dados['telefone']);
        $status_iniciada = StatusIndicacao::proximoStatus();
        $dados['status_indicacao_id'] = $status_iniciada->id;

        Indicacao::create($dados);

        return response()->json([
            'msg' => 'Indicação INICIADA com sucesso!'
        ], 201);
    }
    
    /**
     * Listagem de indicações
     *
     * @return void
     */
    public function listar()
    {
        return response()->json(
            Indicacao::get()
        , 200);
    }
    
    /**
     * Exclusão de indicação
     *
     * @param  int $id
     * @return void
     */
    public function excluir($id)
    {
        $indicacao = Indicacao::find($id);
        if (!$indicacao) {
            return response()->json([
                'msg' => 'Indicação não encontrada!'
            ], 403);
        }

        $indicacao->delete();

        return response()->json([
            'msg' => 'Indicação excluída com sucesso!'
        ], 200);
    }
    
    /**
     * Altera o status da indicação
     *
     * @param  mixed $id
     * @return void
     */
    public function alterarStatus($id)
    {
        $indicacao = Indicacao::find($id);
        if (!$indicacao) {
            return response()->json([
                'msg' => 'Indicação não encontrada!'
            ], 403);
        }

        $novo_status = StatusIndicacao::proximoStatus($indicacao['status_indicacao_id']);
        $indicacao['status_indicacao_id'] = $novo_status->id;

        $indicacao->update();

        return response()->json([
            'msg' => 'Status da indicação alterado para ' . $novo_status->descricao . '!'
        ], 200);
    }
}
