<?php

namespace App\Http\Controllers;

use App\Anime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class JeuAnimesController extends Controller
{
    public function getRandomAnime($dif){
        $animeDejaVu = Session::get('AnimeDejaVu');
        if(isset($dif)){
            //cherche un random anime avec la dif passé en parametre
            $anime=Anime::orderByRaw("RAND()")->where('difficulte',$dif)->first();
            $anime = $anime->getAttributes();

        }
        else{
            //cherche un random anime sans dif
            $anime =Anime::orderByRaw("RAND()")->first();
            $anime = $anime->getAttributes();
          // dd($anime['nom']);
        }
            $cdt = false;
            while ($cdt != true) {
                if (in_array($anime['nom'], $animeDejaVu)) {
                    $anime = Anime::orderByRaw("RAND()")->where('difficulte', $dif)->first();
                    $anime = $anime->getAttributes();
                }
                else{
                    $cdt = true;
                }
            }

        Session::push('AnimeDejaVu', $anime['nom']);
        return $anime;
    }

    public function index(){
        $dif=Input::get('difficulte');
        if(isset($dif)){
            $anime =$this->getRandomAnime($dif);
            return $anime;
        }
        else{
            $dif =null;
            Session::put('AnimeDejaVu',[]);
            $anime =$this->getRandomAnime($dif);
            return view('jeuAnime.index',compact('anime'));
        }
     //   dd($anime['nom']);
    }

    public function verifAnime(Request $request){
       // dd($request->all());
        $difficulte = $request->get('difficulte');
        $nomRentrer = $request->get('nom');
        $nomRef = $request->get('nomRef');
        $win = "false";

        //condition de victoire
        if(strcasecmp($nomRef,$nomRentrer)==0){
            $win="true";
            //voir le pb si il n'y a plus d'animes ds la difficulte choisie
            $anime = $this->getRandomAnime($difficulte);
            return compact('win','anime');
        }
        else
        {

            return $win;
        }
    }
}
