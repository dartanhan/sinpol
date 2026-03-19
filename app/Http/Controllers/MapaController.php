<?php

namespace App\Http\Controllers;

use App\Models\Mapa;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class MapaController extends Controller
{
    protected $request, $mapa;

    public function __construct(Request $request, Mapa $mapa)
    {
        $this->request = $request;
        $this->mapa = $mapa;
    }

    public function index()
    {
        if (Auth::check() === true) {
            $user_data = User::where("id", auth()->user()->id)->first();
            $mapas = $this->mapa->orderBy('id', 'desc')->get();
            return view('admin.mapas.index', compact('mapas', 'user_data'));
        }
        return redirect()->route('login');
    }

    public function store()
    {
        $data = [
            'link' => $this->request->input('link'),
            'status' => true,
        ];

        $this->mapa->create($data);

        return redirect()->back()->with('success', 'Mapa salvo com sucesso.');
    }

    public function update($id)
    {
        try {
            $mapa = $this->mapa->find($id);
            $mapa->link = $this->request->input('link');

            if ($mapa->save()) {
                return redirect()->back()->with('success', 'Atualização efetuada com sucesso.');
            } else {
                return redirect()->back()->with('danger', 'Erro ao atualizar.');
            }
        } catch (Throwable $th) {
            return redirect()->back()->with('danger', 'Erro: ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $mapa = $this->mapa->find($id);
        if (!$mapa) {
            abort(404);
        }
        return response()->json(['success' => true, 'data' => $mapa]);
    }

    public function destroy($id)
    {
        try {
            $mapa = $this->mapa->find($id);
            if (!$mapa) {
                return response()->json(['success' => false, 'message' => 'Mapa não encontrado'], 404);
            }
            $mapa->delete();
            return response()->json(['success' => true, 'message' => 'Excluído com sucesso'], 200);
        } catch (Throwable $th) {
            return response()->json(['success' => false, 'message' => "Erro: " . $th->getMessage()], 500);
        }
    }

    public function atualizarStatus()
    {
        $id = $this->request->input('id');
        $status = $this->request->input('status');

        $mapa = $this->mapa->find($id);
        if($mapa) {
            $mapa->status = $status;
            $mapa->save();
            return response()->json(['success' => true, 'message' => 'Status atualizado.'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Mapa não encontrado.'], 404);
    }
}
