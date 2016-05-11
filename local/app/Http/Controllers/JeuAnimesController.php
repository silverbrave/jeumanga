<?php

namespace App\Http\Controllers;

use App\Anime;
use Illuminate\Http\Request;

use App\Http\Requests;

class JeuAnimesController extends Controller
{
    public function getRandomAnime($dif){
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
        return $anime;
    }

    public function index(){
        $dif=null;
        $anime =$this->getRandomAnime($dif);
     //   dd($anime['nom']);
        return view('jeuAnime.index',compact('anime'));
    }

    public function verifAnime(){

    }
}
