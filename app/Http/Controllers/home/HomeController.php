<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;

use App\Models\Home;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $request,$home;

    public function __construct(Request $request, Home $home){
        $this->request = $request;
        $this->home = $home;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
       /* $noticias = $this->noticia->with('imagens')
            ->where('status',1)
            ->orderBy('id', 'desc')->get();

        $beneficio = $this->beneficio->where('status',1)->first();*/

     //   return view('site.beneficio', compact('noticias','beneficio'));
        return view('home.home');
    }


}
