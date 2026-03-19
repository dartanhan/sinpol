<?php

namespace App\Http\Controllers;

use App\Models\SecaoPost;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Throwable;

class SecaoPostController extends Controller
{
    protected $request, $secaoPost;

    public function __construct(Request $request, SecaoPost $secaoPost)
    {
        $this->request = $request;
        $this->secaoPost = $secaoPost;
    }

    public function index($tipo)
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $posts = $this->secaoPost->where('tipo', $tipo)->orderBy('id', 'desc')->get();
            return view('admin.secao_posts.index', compact('posts', 'user_data', 'tipo'));
        }
        return redirect()->route('login');
    }

    public function store($tipo)
    {
        try {
            $data = [
                'tipo' => $tipo,
                'titulo' => 'Sem título (' . date('d/m/Y H:i:s') . ')',
                'conteudo' => $this->request->input('tinymce_editor'),
                'status' => true,
            ];

            if ($this->request->has('titulo') && !empty($this->request->input('titulo'))) {
                $data['titulo'] = $this->request->input('titulo');
            }

            if (empty($data['conteudo'])) {
                return redirect()->back()->with('danger', 'O campo conteúdo não pode estar vazio.');
            }

            $this->secaoPost->create($data);

            return redirect()->back()->with('success', 'Post criado com sucesso.');
        } catch (Throwable $th) {
            return redirect()->back()->with('danger', 'Erro ao salvar: ' . $th->getMessage());
        }
    }

    public function update($tipo, $id)
    {
        try {
            $post = $this->secaoPost->where('tipo', $tipo)->find($id);

            if ($this->request->has('titulo')) {
                $post->titulo = $this->request->input('titulo');
            }
            
            $post->conteudo = $this->request->input('tinymce_editor');

            if ($post->save()) {
                return redirect()->back()->with('success', 'Atualização efetuada com sucesso.');
            } else {
                return redirect()->back()->with('danger', 'Erro ao atualizar.');
            }
        } catch (Throwable $th) {
            return redirect()->back()->with('danger', 'Erro: ' . $th->getMessage());
        }
    }

    public function edit($tipo, $id)
    {
        $post = $this->secaoPost->where('tipo', $tipo)->find($id);
        if (!$post) {
            abort(404);
        }
        return response()->json(['success' => true, 'data' => $post]);
    }

    public function destroy($tipo, $id)
    {
        try {
            $post = $this->secaoPost->where('tipo', $tipo)->find($id);
            if (!$post) {
                return response()->json(['success' => false, 'message' => 'Post não encontrado'], 404);
            }
            $post->delete();
            return response()->json(['success' => true, 'message' => 'Excluído com sucesso'], 200);
        } catch (Throwable $th) {
            return response()->json(['success' => false, 'message' => "Erro: " . $th->getMessage()], 500);
        }
    }

    public function atualizarStatus($tipo)
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $post = $this->secaoPost->where('tipo', $tipo)->find($id);
        if($post) {
            $post->status = $status;
            $post->save();
            return response()->json(['success' => true, 'message' => 'Status atualizado.'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Post não encontrado.'], 404);
    }
}
