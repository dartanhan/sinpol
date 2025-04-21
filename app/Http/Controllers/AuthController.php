<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    function showLoginForm() {

        //return view('admin.formLogin');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        //dd($request->all());
        // Validação básica dos campos
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns|max:255',
            'password' => 'required|string|min:6|max:100',
            'g-recaptcha-response' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // ReCaptcha v3 via Guzzle
        $secret =  env('NOCAPTCHA_SECRET');
        $recaptcha = $request->input('g-recaptcha-response');

        $client = new Client();

        try {
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => $secret,
                    'response' => $recaptcha,
                    'remoteip' => $request->ip()
                ],
                'verify' => true // pode colocar false temporariamente se o SSL estiver falhando ainda
            ]);

            $body = json_decode((string) $response->getBody(), true);

            //if (!isset($body['success']) || $body['success'] !== true || $body['score'] < 0.5) {
            if (!isset($body['success']) || $body['success'] !== true) {
                return redirect()->back()->withInput()->withErrors([
                    'recaptcha' => 'Você é considerado um bot ou spammer! Score: ' . ($body['score'] ?? 'sem score')
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors([
                'recaptcha' => 'Erro ao verificar reCAPTCHA: ' . $e->getMessage()
            ]);
        }

        // Autenticação por email ou usuário
        $loginField = $request->input('email');
        $password = $request->input('password');

        $credentials = filter_var($loginField, FILTER_VALIDATE_EMAIL)
            ? ['email' => $loginField, 'password' => $password]
            : ['login' => $loginField, 'password' => $password];

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->withInput()->withErrors(['login' => 'Dados informados são inválidos!']);
    }

    function logout(Request $request) {
        //Auth::logout();

       // $this->guard->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('login');
    }

    function register(){
        if(Auth::check() === true){
            $usuarios = User::get();
            $user_data = User::where("id",auth()->user()->id)->first();

            return view('admin.registro', compact('user_data','usuarios'));
        }
        return redirect()->route('login');

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
                return redirect()->route('admin.registro')->with('danger', $error);
            }

            $criado = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            if ($criado)
                return redirect()->route('admin.registro')->with('success', 'Usuário registrado com sucesso.');
        }else{
            return redirect()->route('login');
        }
    }



}
