<?php

namespace App\Http\Controllers;

use App\Models\Diretoria;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;

class DiretoriaController extends Controller
{
    protected $request, $diretoria;

    public function __construct(Request $request, Diretoria $diretoria)
    {
        $this->request = $request;
        $this->diretoria = $diretoria;
    }

    public function index()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();

            $diretorias = $this->diretoria->orderBy('id', 'desc')->get();

            return view('admin.diretoria', compact('diretorias', 'user_data'));

        }
        return redirect()->route('login');
    }


    /**
     * Salvar
     */
    public function store()
    {

        $data = [
            'titulo' => $this->request->input('titulo'),
            'conteudo' => $this->request->input('tinymce_editor'),
            'status' => false,
            'slug' => $this->request->input('slug'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $diretoria = $this->diretoria->create($data);

        if (!$diretoria) {
            return redirect()->route('diretoria.index')->with('danger', 'não foi possível salvar a diretoria.');
        }
        return redirect()->route('diretoria.index')->with('success', 'Diretoria salva com sucesso.');
    }

    /**
     * Atualiza a diretoria
     * @param $id
     * @return RedirectResponse | JsonResponse
     */
    public function update($id)
    {

        try {
            $diretoria = $this->diretoria->find($id);

            $diretoria->titulo = $this->request->input('titulo');
            $diretoria->conteudo = $this->request->input('tinymce_editor');
            $diretoria->slug = $this->request->input('slug');
            $diretoria->updated_at = Carbon::now();

            if ($diretoria->save()) {
                return redirect()->route('diretoria.index')->with('success', 'Atualização efetuada com sucesso.');
            } else {
                return redirect()->route('diretoria.index')->with('danger', 'Erro ao atualizar.');
            }
        } catch (Throwable $th) {
            return response()->json(['success' => false, 'message' => "Error não esperado em diretoria : " . $th->getMessage()], 500);
        }
    }

    /**
     * Edita a diretoria
     * @param $id
     * @return JsonResponse
     */
    public function edit($id)
    {

        $diretoria = $this->diretoria->find($id);

        if (!$diretoria) {
            abort(404); // Retorna um erro 404 se não for encontrada
        }
        return response()->json(['success' => true, 'data' => $diretoria]);
    }

    /**
     * Remover a diretoria
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {

            $diretoria = $this->diretoria->find($id);

            if (!$diretoria) {
                return response()->json(['success' => false, 'message' => 'Diretoria não encontrada'], 404);
            }

            $diretoria->delete();

            return response()->json(['success' => true, 'message' => 'Diretoria excluída com sucesso'], 200);

        } catch (Throwable $th) {
            return response()->json(['success' => false, 'message' => "Error não esperado em diretoria : " . $th->getMessage()], 500);
        }
    }


    /***
     * Atualiza o status para ativo e inativo
     * */
    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $diretoria = $this->diretoria->find($id);
        $diretoria->status = $status;

        $atualizacaoBemSucedida = $diretoria->update();

        $msg = 'Diretoria liberada com sucesso';
        if ($status == 0) {
            $msg = 'Diretoria bloqueada com sucesso!';
        }
        if ($atualizacaoBemSucedida) {
            return response()->json(['success' => true, 'message' => $msg], 200);
        }

        return response()->json(['success' => false, 'message' => 'Erro ao atualizar o status'], 500);

    }
}
