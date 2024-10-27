<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use ReCaptcha\ReCaptcha;


class AuthController extends Controller
{

    public function dashboard() {

        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();

            return view('admin.dashboard', compact('user_data'));
        }
        return redirect()->route('admin.login');

    }

    function showLoginForm() {
        //return view('admin.formLogin');
        return view('auth.login');
    }

    function login(Request $request) {

        $secret = env('DATA_SECRET_KEY');
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$recaptchaResponse");
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            return redirect()->back()->withInput()->withErrors(['Você é considerado um Bot / Spammer!']);
        } else {
            if(!filter_var($request->input("email") , FILTER_VALIDATE_EMAIL)){
                return redirect()->back()->withInput()->withErrors(['Login informado não é valido!']);
            }

            $credentials = [
                'email' => $request->input("email"),
                'password' => $request->input("password")
            ];

            if(Auth::attempt($credentials)){
                return redirect()->route('admin.dashboard');
            }
            return redirect()->back()->withInput()->withErrors(['Dados informados são inválidos!']);
        }
    }

    function logout(Request $request) {
        //Auth::logout();

       // $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('admin.login');
    }

    function register(){
        if(Auth::check() === true){
            $usuarios = User::get();
            $user_data = User::where("id",auth()->user()->id)->first();

            return view('admin.registro', compact('user_data','usuarios'));
        }
        return redirect()->route('admin.login');

    }

    function store(Request $request){
        if(Auth::check() === true) {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ], [
                'name.required' => 'O campo Nome é obrigatório.',
                'email.required' => 'O campo Email é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de e-mail válido.',
                'email.unique' => 'Este e-mail já está em uso.',
                'password.required' => 'O campo Senha é obrigatório.',
                'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
                'password.confirmed' => 'As senhas não coincidem.',
            ]);

            if ($validator->fails()) {
                $error = $validator->errors()->first();
                return redirect()->route('admin.register')->with('danger', $error);
            }

            $criado = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            if ($criado)
                return redirect()->route('admin.register')->with('success', 'Usuário registrado com sucesso.');
        }else{
            return redirect()->route('admin.login');
        }
    }

}