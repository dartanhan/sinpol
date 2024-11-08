<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BeneficioController extends Controller
{
    protected $request,$beneficio;

    public function __construct(Request $request, Beneficio $beneficio){
        $this->request = $request;
        $this->beneficio = $beneficio;
    }

    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            $beneficios = $this->beneficio->orderBy('id', 'desc')->get();

            return  view('admin.beneficio',compact('beneficios','user_data'));

        }
        return redirect()->route('login');
    }


    /**
     * Salvar
     */
    public function store(){

        $data = [
            'titulo' => $this->request->input('titulo'),
            'conteudo' =>  $this->request->input('tinymce_editor'),
            'status' => false,
            'slug' => $this->request->input('slug'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $beneficio = $this->beneficio->create($data);

        if(!$beneficio){
            return redirect()->route('beneficio.index')->with('danger','não foi possível salvar o benefício.');
        }
        return redirect()->route('beneficio.index')->with('success','Benefício salvo com sucesso.');
    }

    /**
     * Atualiza o video
     * @param $id
     * @return RedirectResponse | JsonResponse
     */
    public function update($id){

        try {
            $beneficio = $this->beneficio->find($id);

            $beneficio->titulo = $this->request->input('titulo');
            $beneficio->conteudo =  $this->request->input('tinymce_editor');
            $beneficio->slug = $this->request->input('slug');
            $beneficio->updated_at = Carbon::now();

            if ($beneficio->save()) {
                // return response()->json(['success'=> true, 'message' => 'Notícia atualizada com sucesso'], 200);
                return redirect()->route('beneficio.index')->with('success','Atualização efetuada com sucesso.');
            } else {
                //return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
                return redirect()->route('beneficio.index')->with('danger','Erro ao atualizar.');
            }
        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em benefício : " . $th->getMessage()],500);
        }
    }

    /**
     * Edita o video
     * @param $id
     * @return JsonResponse
     */
    public function edit($id){

        $beneficio = $this->beneficio->find($id);

        if (!$beneficio) {
            abort(404); // Retorna um erro 404 se não for encontrada
        }
        return response()->json(['success' => true, 'data' => $beneficio]);
    }

    /**
     * Remover o video
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {

            $beneficio = $this->beneficio->find($id);

            if (!$beneficio) {
                return response()->json(['success' => false, 'message' => 'Beneficio não encontrado'], 404);
            }

            $beneficio->delete();

            return response()->json(['success' => true, 'message' => 'Beneficio excluído com sucesso'],200);

        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em beneficio : " . $th->getMessage()],500);
        }
    }


    /***
     * Atualiza o status para ativo e inativo
     * */
    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $beneficio = $this->beneficio->find($id);
        $beneficio->status = $status;

        $atualizacaoBemSucedida = $beneficio->update();

        $msg = 'Benefício liberado com sucesso';
        if($status == 0){
            $msg = 'Benefício bloqueado com sucesso!';
        }
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);

    }
}
