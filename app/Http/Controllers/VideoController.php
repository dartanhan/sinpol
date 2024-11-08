<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;

class VideoController extends Controller
{
    protected $request,$video;

    public function __construct(Request $request, Video $video){
        $this->request = $request;
        $this->video = $video;
    }

    public function index()
    {
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            $videos = $this->video->orderBy('id', 'desc')->get();

            return  view('admin.video',compact('videos','user_data'));

        }
        return redirect()->route('login');
    }

    /**
     * Salva o vídeo
    */
    public function store(){

        $data = [
            'link' => $this->request->input('link'),
            'titulo' => $this->request->input('titulo'),
            'subtitulo' => $this->request->input('subtitulo'),
            'status' => false,
            'slug' => $this->request->input('slug'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $video = $this->video->create($data);

        if(!$video){
            return redirect()->route('video.index')->with('danger','não foi possível salvar o vídeo.');
        }
        return redirect()->route('video.index')->with('success','Vídeo salvo com sucesso.');
    }

    /**
     * Atualiza o video
     * @param $id
     * @return RedirectResponse
     */
    public function update($id){
        $video = $this->video->find($id);

        $video->titulo = $this->request->input('titulo');
        $video->subtitulo =  $this->request->input('subtitulo');
        $video->link = $this->request->input('link');
        $video->slug = $this->request->input('slug');
        $video->updated_at = Carbon::now();

        if ($video->save()) {
            // return response()->json(['success'=> true, 'message' => 'Notícia atualizada com sucesso'], 200);
            return redirect()->route('video.index')->with('success','Atualização efetuada com sucesso.');
        } else {
            //return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
            return redirect()->route('video.index')->with('danger','Erro ao atualizar.');
        }
    }

    /**
     * Edita o video
     * @param $id
     * @return JsonResponse
     */
    public function edit($id){

        $video = $this->video->find($id);

        if (!$video) {
            abort(404); // Retorna um erro 404 se não for encontrada
        }
        return response()->json(['success' => true, 'data' => $video]);
    }

    /**
     * Remover o video
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {

            $video = $this->video->find($id);

            if (!$video) {
                return response()->json(['success' => false, 'message' => 'Vídeo não encontrado'], 404);
            }

            $video->delete();

            return response()->json(['success' => true, 'message' => 'Vídeo excluído com sucesso'],200);

        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em vídeo : " . $th->getMessage()],500);
        }
    }

    /***
     * Atualiza o status para ativo e inativo
     * */
    public function atualizarStatus()
    {
        try {
            $id = $this->request->input('id');
            $status = $this->request->input('status');

            $video =  $this->video->find($id);
            $video->status = $status;

            $atualizacaoBemSucedida = $video->update();

            $msg = 'Vídeo liberado com sucesso';
            if($status == 0){
                $msg = 'Vídeo bloqueado com sucesso!';
            }
            if ($atualizacaoBemSucedida) {
                return response()->json(['success'=> true, 'message' => $msg], 200);
            }

            return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 404);

        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error ao atualizar o status : " . $th->getMessage()],500);
        }
    }
}
