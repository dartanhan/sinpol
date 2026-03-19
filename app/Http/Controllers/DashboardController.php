<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Noticia;
use App\Models\Convenio;
use App\Models\Video;
use App\Models\Beneficio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard() {

        if(Auth::check() === true){
            $user_data = User::where("id",auth()->user()->id)->first();
            
            $noticiasCount = Noticia::count();
            $conveniosCount = Convenio::count();
            $videosCount = Video::count();
            $beneficiosCount = Beneficio::count();
            $usersCount = User::count();
            
            $noticias = Noticia::orderBy('created_at', 'desc')->take(5)->get();

            return view('admin.dashboard', compact(
                'user_data', 
                'noticiasCount', 
                'conveniosCount', 
                'videosCount', 
                'beneficiosCount', 
                'usersCount',
                'noticias'
            ));
        }
        return redirect()->route('login');

    }
}
