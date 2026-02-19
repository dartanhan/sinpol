<?php

namespace App\Http\Controllers;

use App\Models\Pagina;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PaginaController extends Controller
{
    protected $request, $pagina;

    public function __construct(Request $request, Pagina $pagina)
    {
        $this->request = $request;
        $this->pagina = $pagina;
    }

    public function index()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $paginas = $this->pagina->orderBy('titulo', 'asc')->get();
            return view('admin.paginas.index', compact('paginas', 'user_data'));
        }
        return redirect()->route('login');
    }

    public function store()
    {
        // Se o slug não for fornecido, gera a partir do título
        $slug = $this->request->input('slug');
        if (empty($slug) && $this->request->has('titulo')) {
            $slug = Str::slug($this->request->input('titulo'));
        }

        $data = [
            'titulo' => $this->request->input('titulo'),
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => true, // Cria ativo por padrão
            'slug' => $slug,
        ];

        $pagina = $this->pagina->create($data);

        return redirect()->route('pagina.index')->with('success', 'Página criada com sucesso.');
    }

    public function update($id)
    {
        try {
            $pagina = $this->pagina->find($id);

            $pagina->titulo = $this->request->input('titulo');
            $pagina->conteudo = $this->request->input('tinymce_editor');

            // Atualiza slug se fornecido ou regenera se vazio (opcional, aqui mantendo o que vier ou o antigo)
            if ($this->request->has('slug') && !empty($this->request->input('slug'))) {
                $pagina->slug = $this->request->input('slug');
            } else {
                $pagina->slug = Str::slug($this->request->input('titulo'));
            }

            if ($pagina->save()) {
                return redirect()->route('pagina.index')->with('success', 'Atualização efetuada com sucesso.');
            } else {
                return redirect()->route('pagina.index')->with('danger', 'Erro ao atualizar.');
            }
        } catch (Throwable $th) {
            return redirect()->route('pagina.index')->with('danger', 'Erro: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $pagina = $this->pagina->find($id);
        if (!$pagina) {
            abort(404);
        }
        return response()->json(['success' => true, 'data' => $pagina]);
    }

    public function destroy($id)
    {
        try {
            $pagina = $this->pagina->find($id);
            if (!$pagina) {
                return response()->json(['success' => false, 'message' => 'Página não encontrada'], 404);
            }
            $pagina->delete();
            return response()->json(['success' => true, 'message' => 'Página excluída com sucesso'], 200);
        } catch (Throwable $th) {
            return response()->json(['success' => false, 'message' => "Erro: " . $th->getMessage()], 500);
        }
    }

    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $pagina = $this->pagina->find($id);
        $pagina->status = $status;
        $pagina->save();

        return response()->json(['success' => true, 'message' => 'Status atualizado.'], 200);
    }
}
