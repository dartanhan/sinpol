<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;

use App\Models\Beneficio;
use App\Models\Convenio;
use App\Models\Home;
use App\Models\Noticia;
use App\Models\SocialMedia;
use App\Models\Video;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $request,$home,$noticias,$ultimasNoticias,$noticiasBreakNews,$noticiasPopulares,$videos;

    public function __construct(Request $request, Home $home, Noticia $noticias){
        $this->request = $request;
        $this->home = $home;
        $this->noticias = $noticias;
        $this->ultimasNoticias = Noticia::with('imagens')->where('status',1)
            ->orderBy('id', 'desc')->take(5)->get();
        $this->noticiasBreakNews = Noticia::get()->sortByDesc('created_at')->take(10);
        $this->noticiasPopulares = Noticia::orderBy('qtd_views', 'desc')->take(3)->get();
        $this->videos =  Video::where('status',true)->take(3)->get();
        $this->socialmedias = SocialMedia::where('status',1)->orderBy('id', 'desc')->get();

    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $this->noticias = $this->noticias->with('imagens','user')
            ->where('status',1)
            ->where('destaque',1)
            ->orderBy('id', 'desc')->get();

        $noticiasPrincipais = $this->noticias->take(3); // Primeiras 3 notícias
        $noticiasSecundarias = $this->noticias->skip(3)->take(4); // Próximas 4 notícias que não estão nas principais
        //$noticiasBreakNews = Noticia::get()->skip(7)->sortByDesc('created_at')->take(5);
        $noticiasDestaques  = $this->noticias->skip(3)->take(10);
        $noticiaSingle = $this->noticias->take(1);

        return view('home.home', ['ultimasNoticias'=>$this->ultimasNoticias,
                                        'noticiasDestaques' => $noticiasDestaques,
                                        'noticiasPrincipais' => $noticiasPrincipais,
                                        'noticiasSecundarias' => $noticiasSecundarias,
                                        'noticiasBreakNews'=>$this->noticiasBreakNews,
                                        'noticiaSingle' =>$noticiaSingle,
                                        'noticiasPopulares' => $this->noticiasPopulares,
                                        'videos' => $this->videos,
                                        'socialmedias' =>$this->socialmedias]);
    }

    public function single($pagina,$slug=null)
    {
        $data =[];
        switch ($pagina) {
            case 'noticia':
                $noticiaSingle = Noticia::with('imagens','user')
                    ->where('status',1)
                    ->where('slug',$slug)
                    ->orderBy('id', 'desc')->first();

                if ($noticiaSingle && $noticiaSingle->updated_at->diffInMinutes(now()) >= 10) {
                    $noticiaSingle->increment('qtd_views');
                    $noticiaSingle->update();
                }
                $data = ['noticiaSingle' =>$noticiaSingle,
                    'ultimasNoticias' => $this->ultimasNoticias,
                    'noticiasBreakNews' =>  $this->noticiasBreakNews,
                    'noticiasPopulares' => $this->noticiasPopulares,
                    'videos' => $this->videos,
                    'socialmedias' =>$this->socialmedias];
                break;
            case 'beneficio':
                $beneficios = Beneficio::where('status',1)->orderBy('id', 'desc')->get();
                $data = ['beneficios' =>$beneficios,
                        'noticiasBreakNews' =>  $this->noticiasBreakNews,
                        'noticiasPopulares' => $this->noticiasPopulares,
                        'ultimasNoticias' => $this->ultimasNoticias,
                        'videos' => $this->videos,
                        'socialmedias' =>$this->socialmedias];
                break;
            case 'convenio':
                $convenios = Convenio::where('status',1)->orderBy('id', 'desc')->get();
                $data = ['convenios' =>$convenios,
                    'noticiasBreakNews' =>  $this->noticiasBreakNews,
                    'noticiasPopulares' => $this->noticiasPopulares,
                    'ultimasNoticias' => $this->ultimasNoticias,
                    'videos' => $this->videos,
                    'socialmedias' =>$this->socialmedias];
                break;
            case 'outrasnoticias':
                $noticias = $this->noticias->with('imagens','user')
                    ->where('status',1)
                    ->where('destaque',1)
                    ->orderBy('id', 'desc')->paginate(5);

                $data = ['noticias' =>$noticias,
                    'noticiasBreakNews' =>  $this->noticiasBreakNews,
                    'noticiasPopulares' => $this->noticiasPopulares,
                    'ultimasNoticias' => $this->ultimasNoticias,
                    'videos' => $this->videos,
                    'socialmedias' =>$this->socialmedias];
                break;
            case 'socialmedia':

                $data = ['socialmedias' =>$this->socialmedias,
                    'noticiasBreakNews' =>  $this->noticiasBreakNews,
                    'noticiasPopulares' => $this->noticiasPopulares,
                    'ultimasNoticias' => $this->ultimasNoticias,
                    'videos' => $this->videos];
                break;
            case 'outrosvideos':
                $videos = Video::where('status',1)->orderBy('id', 'desc')->paginate(5);

                $noticias = $this->noticias->with('imagens','user')
                    ->where('status',1)
                    ->where('destaque',1)
                    ->orderBy('id', 'desc')->paginate(4);

                $data = ['noticias' =>$noticias,
                    'noticiasBreakNews' =>  $this->noticiasBreakNews,
                    'noticiasPopulares' => $this->noticiasPopulares,
                    'ultimasNoticias' => $this->ultimasNoticias,
                    'videos' => $videos,
                    'socialmedias' =>$this->socialmedias];
                break;
            default :
              //  $data .= ['socialmedias' =>$this->socialmedias];
        }

        return view('home.'.$pagina, $data);

    }

}
