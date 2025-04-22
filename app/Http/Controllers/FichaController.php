<?php

namespace App\Http\Controllers;

use App\Http\Requests\FichaRequest;
use App\Mail\FichaSindicato;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FichaController extends Controller
{
    public function index(){
        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            return  view('home.ficha',compact('user_data'));

        }
        return redirect()->route('login');
    }

    public function enviar(FichaRequest $request)
    {
        try {
            $arquivos = [];

            if ($request->hasFile('arquivos')) {
                foreach ($request->file('arquivos') as $file) {
                    $arquivos[] = $file->store('fichas_temp', 'public');
                }
            }

            //envia o email
            Mail::to('dartanhan.lima@gmail.com')
                //->cc('secretaria@sinpol.com.br')
                ->send(
                new FichaSindicato($request->all(), $arquivos)
            );

            return back()->with('success', 'Ficha enviada com sucesso!');

        } catch (\Exception $e) {
            Log::error('Erro ao enviar ficha: ' . $e->getMessage());

            return back()->withErrors(['erro_envio' => 'Erro ao enviar ficha: ' . $e->getMessage()]);
        }
    }
}
