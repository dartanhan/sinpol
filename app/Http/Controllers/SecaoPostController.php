<?php

namespace App\Http\Controllers;

use App\Models\SecaoPost;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\GaleriaImagem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        try {
            if (Auth::check() === true) {
                $user_data = User::where("id", auth()->user()->id)->first();
                $posts = $this->secaoPost->where('tipo', $tipo)->orderBy('id', 'desc')->get();

                // Reparo de títulos antigos "Sem título"
                foreach($posts as $post) {
                    if (strpos($post->titulo, 'Sem título') === 0) {
                        $post->titulo = $this->getFormatTitle($tipo);
                        $post->save();
                    }
                }

                return view('admin.secao_posts.index', compact('posts', 'user_data', 'tipo'));
            }
            return redirect()->route('login');
        } catch (Throwable $th) {
            Log::error("Erro no index do SecaoPostController ($tipo): " . $th->getMessage());
            return redirect()->back()->with('danger', 'Erro ao carregar registros: ' . $th->getMessage());
        }
    }

    public function create($tipo)
    {
        try {
            if (Auth::check() === true) {
                $user_data = User::where("id", auth()->user()->id)->first();
                $images = GaleriaImagem::get();
                return view('admin.secao_posts.create', compact('user_data', 'tipo', 'images'));
            }
            return redirect()->route('login');
        } catch (Throwable $th) {
            Log::error("Erro no create do SecaoPostController ($tipo): " . $th->getMessage());
            return redirect()->back()->with('danger', 'Erro ao carregar formulário: ' . $th->getMessage());
        }
    }

    public function store($tipo)
    {
        try {
            $tituloPadrao = $this->getFormatTitle($tipo);

            $data = [
                'tipo' => $tipo,
                'titulo' => $tituloPadrao,
                'conteudo' => $this->request->input('tinymce_editor'),
                'status' => $this->request->input('status', 1),
            ];

            if ($this->request->has('titulo') && !empty($this->request->input('titulo')) && $this->request->input('titulo') !== 'Sem título') {
                $data['titulo'] = $this->request->input('titulo');
            }

            if (empty($data['conteudo'])) {
                return redirect()->back()->withInput()->with('danger', 'O campo conteúdo não pode estar vazio.');
            }

            $this->secaoPost->create($data);

            return redirect()->route($tipo.'.index')->with('success', 'Post criado com sucesso.');
        } catch (Throwable $th) {
            Log::error("Erro no store do SecaoPostController ($tipo): " . $th->getMessage());
            return redirect()->back()->withInput()->with('danger', 'Erro ao salvar: ' . $th->getMessage());
        }
    }

    private function getFormatTitle($tipo)
    {
        $titulos = [
            'sinpol-animal' => 'SINPOL ANIMAL',
            'sinpol-mulher' => 'SINPOL MULHER',
            'sinpol-permutas' => 'SINPOL PERMUTAS',
            'classificados-sinpol' => 'CLASSIFICADOS DO SINPOL',
            'sinpol-fiscaliza' => 'SINPOL FISCALIZA',
            'sinpol-na-rua' => 'SINPOL NA RUA',
            'sinpol-denuncias' => 'SINPOL DENÚNCIAS',
            'sinpol-idoso' => 'SINPOL IDOSO',
            'sinpol-esportes' => 'SINPOL ESPORTES',
            'sinpol-peritos' => 'SINPOL PERITOS',
            'diretoria' => 'DIRETORIA',
            'historia' => 'HISTÓRIA',
            'fale-conosco' => 'FALE CONOSCO',
            'como-chegar' => 'COMO CHEGAR',
            'principais-links' => 'PRINCIPAIS LINKS',
            'convenio' => 'CONVÊNIOS'
        ];

        return isset($titulos[$tipo]) ? $titulos[$tipo] : strtoupper(str_replace('-', ' ', $tipo));
    }

    public function update($id, $tipo)
    {
        try {
            $post = $this->secaoPost->where('tipo', $tipo)->find($id);

            if (!$post) {
                 return redirect()->route($tipo.'.index')->with('danger', 'Registro não encontrado.');
            }

            if ($this->request->has('titulo')) {
                $post->titulo = $this->request->input('titulo');
            }
            
            $post->conteudo = $this->request->input('tinymce_editor');

            if ($this->request->has('status')) {
                $post->status = $this->request->input('status');
            }

            if ($post->save()) {
                return redirect()->route($tipo.'.index')->with('success', 'Atualização efetuada com sucesso.');
            } else {
                return redirect()->back()->withInput()->with('danger', 'Erro ao atualizar.');
            }
        } catch (Throwable $th) {
            Log::error("Erro no update do SecaoPostController ($tipo, $id): " . $th->getMessage());
            return redirect()->back()->withInput()->with('danger', 'Erro: ' . $th->getMessage());
        }
    }

    public function edit($id, $tipo)
    {
        try {
            if (Auth::check() === true) {
                $user_data = User::where("id", auth()->user()->id)->first();
                $post = $this->secaoPost->where('tipo', $tipo)->find($id);
                if (!$post) {
                    return redirect()->route($tipo.'.index')->with('danger', 'Registro não encontrado.');
                }
                $images = GaleriaImagem::get();
                return view('admin.secao_posts.edit', compact('post', 'user_data', 'tipo', 'images'));
            }
            return redirect()->route('login');
        } catch (Throwable $th) {
            Log::error("Erro no edit do SecaoPostController ($tipo, $id): " . $th->getMessage());
            return redirect()->route($tipo.'.index')->with('danger', 'Erro ao carregar edição: ' . $th->getMessage());
        }
    }

    public function destroy($id, $tipo)
    {
        try {
            $post = $this->secaoPost->where('tipo', $tipo)->find($id);
            if (!$post) {
                return response()->json(['success' => false, 'message' => 'Post não encontrado'], 404);
            }
            $post->delete();
            return response()->json(['success' => true, 'message' => 'Excluído com sucesso'], 200);
        } catch (Throwable $th) {
            Log::error("Erro no destroy do SecaoPostController ($tipo, $id): " . $th->getMessage());
            return response()->json(['success' => false, 'message' => "Erro: " . $th->getMessage()], 500);
        }
    }

    public function atualizarStatus($tipo)
    {
        try {
            $id = $this->request->input('id');
            $status = $this->request->input('status');

            $post = $this->secaoPost->where('tipo', $tipo)->find($id);
            if($post) {
                $post->status = $status;
                $post->save();
                return response()->json(['success' => true, 'message' => 'Status atualizado.'], 200);
            }
            return response()->json(['success' => false, 'message' => 'Post não encontrado.'], 404);
        } catch (Throwable $th) {
            Log::error("Erro no atualizarStatus do SecaoPostController ($tipo): " . $th->getMessage());
            return response()->json(['success' => false, 'message' => "Erro: " . $th->getMessage()], 500);
        }
    }
}
