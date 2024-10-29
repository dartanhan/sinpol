<?php

namespace App\Http\Controllers;

use App\Models\GaleriaImagem;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        $noticia = $this->noticia->create([
            'titulo' => $this->request->input('titulo'),
            'subtitulo' => $this->request->input('subtitulo'),
            'imagem_id' => $this->request->input('idImagemDestaque'),
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => false
        ]);

        if(!$noticia){
            return redirect()->route('noticia.index')->with('danger','não foi possível criar a notícia.');
        }
        return redirect()->route('noticia.index')->with('success','Notícia criada com sucesso.');
    }

    public function create(){

    }

    public function destroy(int $id)
    {
        $noticia = Noticia::find($id);

        if (!$noticia) {
            return response()->json(['success' => false, 'message' => 'Notícia não encontrada'], 404);
        }

        $noticia->delete();

        return response()->json(['success' => true, 'message' => 'Notícia excluída com sucesso']);
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

        $atualizacaoBemSucedida = $noticia->update();

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

}