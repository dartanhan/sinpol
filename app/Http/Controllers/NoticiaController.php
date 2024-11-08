<?php

namespace App\Http\Controllers;

use App\Models\GaleriaImagem;
use App\Models\Noticia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Throwable;

class NoticiaController extends Controller
{
    protected $request,$noticia,$galleryImage;

    public function __construct(Request $request, Noticia $noticia, GaleriaImagem $galleryImage){

        $this->request = $request;
        $this->galleryImage = $galleryImage;
        $this->noticia = $noticia;
    }
    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            $images = $this->galleryImage->get();
            $noticias = Noticia::with('imagens')->orderBy('id', 'desc')->get();

            return  view('admin.noticia',compact('noticias','images','user_data'));

        }
        return redirect()->route('login');
    }

    public function store(){

        $data = [
            'titulo' => $this->request->input('titulo'),
            'subtitulo' => $this->request->input('subtitulo'),
            'imagem_id' => $this->request->input('idImagemDestaque'),
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => false,
            'destaque' => $this->request->has('destaque'),
            'slug' => $this->request->input('slug'),
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $noticia = $this->noticia->create($data);

        if(!$noticia){
            return redirect()->route('noticia.index')->with('danger','não foi possível criar a notícia.');
        }
        return redirect()->route('noticia.index')->with('success','Notícia criada com sucesso.');
    }

    public function create(){

    }

    public function destroy(int $id)
    {
        try {

            $noticia = Noticia::find($id);

            if (!$noticia) {
                return response()->json(['success' => false, 'message' => 'Notícia não encontrada'], 404);
            }

            $noticia->delete();

            return response()->json(['success' => true, 'message' => 'Notícia excluída com sucesso']);

        } catch (Throwable  $th){
            return response()->json(['success' => false, 'message' => "Error não esperado em notícia : " . $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        //$noticia = Noticia::find($id);
        $noticia = Noticia::with('imagens')->find($id);

         if (!$noticia) {
            abort(404); // Retorna um erro 404 se a notícia não for encontrada
        }
        return response()->json(['success' => true, 'data' => $noticia]);
    }

    public function update($id)
    {
        $noticia = Noticia::find($id);

        $noticia->titulo = $this->request->input('titulo');
        $noticia->subtitulo =  $this->request->input('subtitulo');
        $noticia->conteudo =  $this->request->input('tinymce_editor');
        $noticia->imagem_id =  $this->request->input('idImagemDestaque');
        $noticia->destaque = $this->request->has('destaque');
        $noticia->slug = $this->request->input('slug');
        $noticia->updated_at = Carbon::now();

        $atualizacaoBemSucedida = $noticia->save();

        if ($atualizacaoBemSucedida) {
           // return response()->json(['success'=> true, 'message' => 'Notícia atualizada com sucesso'], 200);
            return redirect()->route('noticia.index')->with('success','Notícia atualizada com sucesso.');
        } else {
            //return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
            return redirect()->route('noticia.index')->with('danger','Erro ao atualizar o status.');
        }

    }

    /***
     * Atualiza o status para ativo e inativo
     * */
    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $noticia =  $this->noticia->find($id);
        $noticia->status = $status;

        $atualizacaoBemSucedida = $noticia->update();

        $msg = 'Notícia liberada com sucesso';
        if($status == 0){
            $msg = 'Notícia bloqueada com sucesso!';
        }
        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }

        return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);

    }

    /***
     * Atualiza o se é destaque ou não para ativo e inativo
     * */
    public function atualizarDestaque()
    {

        $id = $this->request->input('id');
        $status = $this->request->input('destaque');

        $noticia =  $this->noticia->find($id);
        $noticia->destaque = $status;

        $atualizacaoBemSucedida = $noticia->update();

        $msg = 'Notícia ativada como destaque com sucesso!';
        if($status == 0){
            $msg = 'Notícia desativada como destaque com sucesso!';
        }

        if ($atualizacaoBemSucedida) {
            return response()->json(['success'=> true, 'message' => $msg], 200);
        }
            return response()->json(['success'=> false,'message' => 'Erro ao atualizar o status'], 500);
    }

    /**
     * Remove a imagem da galeria
     * @return JsonResponse
     */
    public function removeImageGallery(){

        $imageId = $this->request->input('image_id');

        // Verifique se a imagem está associada a alguma notícia
        $linkedNews = $this->noticia->where('imagem_id', $imageId)->exists();

        if ($linkedNews) {
            // Retornar uma mensagem de erro caso a imagem esteja vinculada a uma notícia
            return response()->json([
                'success' => false,
                'message' => 'A imagem não pode ser excluída, pois está associada a uma notícia.'
            ], 400);
        }

        // Caso não esteja vinculada, excluir a imagem da tabela de galeria de imagens
        $image = $this->galleryImage->where('id', $imageId)->first();

        if (!$image) {
            return response()->json([
                'success' => false,
                'message' => 'A imagem não foi encontrada.'
            ], 404);
        }

        $this->galleryImage->where('id', $imageId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Imagem excluída com sucesso.'
        ]);
    }

}
