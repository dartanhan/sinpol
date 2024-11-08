<?php

namespace App\Http\Controllers;

use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SocialMediaController extends Controller
{
    protected $request,$socialMedia;

    public function __construct(Request $request, SocialMedia $socialMedia){
        $this->request = $request;
        $this->socialMedia = $socialMedia;
    }

    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            $socialMedias = $this->socialMedia->orderBy('id', 'desc')->get();

            return  view('admin.social-media',compact('socialMedias','user_data'));

        }
        return redirect()->route('login');
    }


    /**
     * Salvar
     */
    public function store(){

        $data = [
            'titulo' => $this->request->input('titulo'),
            'link' => $this->request->input('link'),
            'status' => false,
            'slug' => $this->request->input('slug'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $retorno = $this->socialMedia->create($data);

        if(!$retorno){
            return redirect()->route('socialmedia.index')->with('danger','não foi possível salvar o Social Media.');
        }
        return redirect()->route('socialmedia.index')->with('success','Social Media salvo com sucesso.');
    }

    /**
     * Atualiza o video
     * @param $id
     * @return RedirectResponse | JsonResponse
     */
    public function update($id){

        try {
            $socialMedia = $this->socialMedia->find($id);

            $socialMedia->titulo = $this->request->input('titulo');
            $socialMedia->link = $this->request->input('link');
            $socialMedia->slug = $this->request->input('slug');
            $socialMedia->updated_at = Carbon::now();

            if ($socialMedia->save()) {
                return redirect()->route('socialmedia.index')->with('success','Atualização efetuada com sucesso.');
            } else {
                //return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
                return redirect()->route('socialmedia.index')->with('danger','Erro ao atualizar social media.');
            }
        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em social media : " . $th->getMessage()],500);
        }
    }

    /**
     * Edita o video
     * @param $id
     * @return JsonResponse
     */
    public function edit($id){

        $retorno = $this->socialMedia->find($id);

        if (!$retorno) {
            abort(404); // Retorna um erro 404 se não for encontrada
        }
        return response()->json(['success' => true, 'data' => $retorno]);
    }

    /**
     * Remover o video
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {

            $retorno = $this->socialMedia->find($id);

            if (!$retorno) {
                return response()->json(['success' => false, 'message' => 'Social Media não encontrado'], 404);
            }

            $retorno->delete();

            return response()->json(['success' => true, 'message' => 'Social Media excluído com sucesso'],200);

        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em Social Media : " . $th->getMessage()],500);
        }
    }


    /***
     * Atualiza o status para ativo e inativo
     * */
    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $data = $this->socialMedia->find($id);
        $data->status = $status;

        $atualizacaoBemSucedida = $data->update();

        $msg = 'Social Media liberado com sucesso';
        if($status == 0){
            $msg = 'Social Media bloqueado com sucesso!';
        }
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status Social Media'], 500);

    }
}
