<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UsuarioController extends Controller
{
    protected $request,$usuario;

    public function __construct(Request $request, User $usuario){
        $this->request = $request;
        $this->usuario = $usuario;
    }



    /**
     * Atualiza o video
     * @param $id
     * @return RedirectResponse | JsonResponse
     */
    public function update($id){

        try {
            $validator = Validator::make($this->request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'name.required' => 'O campo Nome é obrigatório.',
                'email.required' => 'O campo Email é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'email.unique' => 'Este e-mail já está em uso.',
                'password.required' => 'O campo Senha é obrigatório.',
                'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
                'password.confirmed' => 'As senhas não coincidem.',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->route('admin.registro')->with('danger', $error);
            }

            $data = $this->usuario->find($id);

            $data->name = $this->request->input('name');
            $data->email =  $this->request->input('email');
            $data->password = Hash::make($this->request->input('password'));


            if ($data->save()) {
                // return response()->json(['success'=> true, 'message' => 'Notícia atualizada com sucesso'], 200);
                return redirect()->route('admin.registro')->with('success','Atualização efetuada com sucesso.');
            } else {
                //return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
                return redirect()->route('admin.registro')->with('danger','Erro ao atualizar.');
            }
        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em usuário : " . $th->getMessage()],500);
        }
    }

    /**
     * Edita o video
     * @param $id
     * @return JsonResponse
     */
    public function edit($id){

        $usuario = $this->usuario->find($id);

        if (!$usuario) {
            abort(404); // Retorna um erro 404 se não for encontrada
        }
        return response()->json(['success' => true, 'data' => $usuario]);
    }

    /**
     * Remover o video
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {

            $data = $this->usuario->find($id);

            if (!$data) {
                return response()->json(['success' => false, 'message' => 'Usuário não encontrado'], 404);
            }

            $data->delete();

            return response()->json(['success' => true, 'message' => 'Usuário excluído com sucesso'],200);

        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em usuário : " . $th->getMessage()],500);
        }
    }

}
