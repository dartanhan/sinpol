<?php

namespace App\Http\Controllers;

use App\Models\Beneficio;
use App\Models\Convenio;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ConvenioController extends Controller
{
    protected $request,$convenio;

    public function __construct(Request $request, Convenio $convenio){
        $this->request = $request;
        $this->convenio = $convenio;
    }

    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            $convenios = $this->convenio->orderBy('id', 'desc')->get();

            return  view('admin.convenio',compact('convenios','user_data'));

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

        $convenios = $this->convenio->create($data);

        if(!$convenios){
            return redirect()->route('convenio.index')->with('danger','não foi possível salvar o convênio.');
        }
        return redirect()->route('convenio.index')->with('success','Convênio salvo com sucesso.');
    }

    /**
     * Atualiza o video
     * @param $id
     * @return RedirectResponse | JsonResponse
     */
    public function update($id){

        try {
            $data = $this->convenio->find($id);

            $data->titulo = $this->request->input('titulo');
            $data->conteudo =  $this->request->input('tinymce_editor');
            $data->slug = $this->request->input('slug');
            $data->updated_at = Carbon::now();

            if ($data->save()) {
                // return response()->json(['success'=> true, 'message' => 'Notícia atualizada com sucesso'], 200);
                return redirect()->route('convenio.index')->with('success','Atualização efetuada com sucesso.');
            } else {
                //return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
                return redirect()->route('convenio.index')->with('danger','Erro ao atualizar.');
            }
        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em convênio : " . $th->getMessage()],500);
        }
    }

    /**
     * Edita o video
     * @param $id
     * @return JsonResponse
     */
    public function edit($id){

        $data = $this->convenio->find($id);

        if (!$data) {
            abort(404); // Retorna um erro 404 se não for encontrada
        }
        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Remover o video
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {

            $data = $this->convenio->find($id);

            if (!$data) {
                return response()->json(['success' => false, 'message' => 'Convênio não encontrado'], 404);
            }

            $data->delete();

            return response()->json(['success' => true, 'message' => 'Convênio excluído com sucesso'],200);

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

        $data = $this->convenio->find($id);
        $data->status = $status;

        $atualizacaoBemSucedida = $data->update();

        $msg = 'Convênio liberado com sucesso';
        if($status == 0){
            $msg = 'Convênio bloqueado com sucesso!';
        }
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);

    }
}
