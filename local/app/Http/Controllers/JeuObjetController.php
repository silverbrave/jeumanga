<?php

namespace App\Http\Controllers;

use App\Anime;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class JeuObjetController extends Controller
{
    public function getRandomObjet($dif){
        $objetDejaVu = Session::get('ObjetDejaVu');
        if(isset($dif)){
            //cherche un random objet avec la dif passé en parametre
            $objetRef=Anime::orderByRaw("RAND()")->where('difficulte',$dif)->first();
            $objetRef = $objetRef->getAttributes();
            dd($objetRef);
            $animeDejaVu = Session::get('AnimeDejaVu');
            //   dd($animeDejaVu);
            $nbAnime =  DB::table('animes')->where('difficulte',$dif)->count();
            //    dd($nbAnime);
            $cdt = false;
            $i=1;
            while ($i<=$nbAnime && $cdt!=true) {
                if (in_array($objetRef['nom'], $animeDejaVu)) {
                   $objetRef = Anime::orderByRaw("RAND()")->where('difficulte', $dif)->first();
                   $objetRef = $objetRef->getAttributes();
                    $i++;
                }
                else{
                    $cdt =true;
                    Session::push('AnimeDejaVu', $objetRef['nom']);
                    return $objetRef;
                }
            }
        }
        else{
            //cherche un random anime sans dif
            $objetRef =Anime::orderByRaw("RAND()")->first();
            $objetRef = $objetRef->getAttributes();
            $objetRef = $objetRef['objetRef'];
            dd($objetRef);
            return $objetRef;
        }


    }

    public function index(){
        $dif=Input::get('difficulte');
        if(isset($dif)){
            $objetRef =$this->getRandomObjet($dif);
            return $objetRef;
        }
        else{
            $dif =null;
            Session::put('ObjetDejaVu',[]);
            $objetRef =$this->getRandomObjet($dif);
            return view('jeuObjet.index',compact('objetRef'));
        }
    }
}
