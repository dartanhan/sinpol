<?php

namespace App\Http\Controllers;

use App\Models\GaleriaImagem;
use App\Models\Noticia;
use App\Models\TemporaryFile;
use HTMLPurifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;


class UploadController extends Controller
{
    protected $request,$temporaryFile,$galeriaImagem;

    public function __construct(Request $request, TemporaryFile $temporaryFile, GaleriaImagem $galeriaImagem){

        $this->request = $request;
        $this->temporaryFile = $temporaryFile;
        $this->galeriaImagem = $galeriaImagem;
    }
    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            $images = $this->galeriaImagem->orderBy('id','desc')->paginate(10);

            return  view('admin.galeria',compact('images','user_data'));
        }
        return redirect()->route('login');
    }

    public function uploadImagem()
    {
        $dados = $this->request->all();

        $this->request->validate([
            'file' => 'image|mimes:jpeg,png,jpg,gif,pdf|max:2048', // Adicione as validações necessárias
        ]);

        // Filtra o conteúdo usando o HTMLPurifier
        $purifier = new HTMLPurifier();
        $conteudoFiltrado = $purifier->purify($dados['tinymce-editor']);

        $noticia = new Noticia();
        $noticia->titulo = $dados['titulo'] !== null ? $dados['titulo'] : '';
        $noticia->conteudo = $conteudoFiltrado;
        $noticia->status = true;
        $noticia->data =  now();
        $noticia->save();

        return redirect()->back()->with('success', 'Dados salvos com sucesso');

    }

    public function store(){

        $temp_file = TemporaryFile::where('folder',$this->request->image)->first();

        if($temp_file){
            Storage::copy('posts/tmp/'.$temp_file->folder.'/'.$temp_file->file,'posts/files/'.$temp_file->file);

            GaleriaImagem::create([
                       'path' =>  $temp_file->file
            ]);
            Storage::deleteDirectory('posts/tmp/'.$temp_file->folder);
            $temp_file->delete();
            return redirect()->route('upload.index')->with('success','Upload efetuado com sucesso!');
        }
        return redirect()->route('upload.index')->with('danger','Favor informe o arquivo para upload!');
    }

    public function tmpUpload(){

        if($this->request->hasFile('image')){
            $image = $this->request->file('image');
            $nome_unico = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $folder = uniqid('posts',true);
            $image->storeAs('posts/tmp/'.$folder,$nome_unico,'public');
            $this->temporaryFile->folder = $folder;
            $this->temporaryFile->file =  $nome_unico;

            $this->temporaryFile->save();
            return $folder;
        }
    return '';
    }

    public function tmpDelete(){
        $temp_file = TemporaryFile::where('folder',$this->request->getContent())->first();

        if($temp_file){
            Storage::deleteDirectory('posts/tmp/'.$temp_file->folder);
            $temp_file->delete();
            return response('');
        }
    }

    public function show(){
        $this->tmpDelete();
    }

    public function destroy(){
        $this->tmpDelete();
    }
}
