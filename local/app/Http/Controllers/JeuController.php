<?php

namespace App\Http\Controllers;

use App\Anime;
use App\Personnage;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JeuController extends Controller
{
    public function getRandomPerso(){
        $anime =Anime::orderByRaw("RAND()")->first();
       // $anime=Anime::all()->random(1);
        $anime =$anime->getAttributes();
        //pour avoir un element d'anime utilisez la notation ci dessous
       // dd($anime['id']);
        $perso=Personnage::orderByRaw("RAND()")->where('idAnime',$anime['id'])->first();
        $perso = $perso->getAttributes();
         return compact('anime','perso');
    }


    public function index(){
        $tab=$this->getRandomPerso();
        $anime = $tab['anime'];
        $perso = $tab['perso'];

        return view('jeuPerso.index',compact('anime','perso'));
    }

    public function verifNom(Request $request){
       //dd($request->all());
        $nomRentrer = $request->get('nom');
        //dd($nom);
        $prenomRef = $request->get('prenomPerso');
        $nomRef = $request->get('nomRef');
        $animeOld = $request->get('anime');

        $win = "false";

        if(strcasecmp($nomRentrer,$nomRef)==0 || strcasecmp($nomRentrer,$prenomRef)==0){
            $win="true";
           // dd('win');
            $tab=$this->getRandomPerso();
            $anime = $tab['anime'];
            $perso = $tab['perso'];
            if(strcasecmp($perso['nom'],$nomRef)==0 || strcasecmp($perso['prenom'],$prenomRef)==0){
                $this->verifNom($request);
            }
          //  dd($perso['nom']);
           // Session::flash('flash_message', "Bien joué! Place au personnage suivant.");
            return compact('win','anime','perso');
        }
        else{
            return $win;
        }

    }
}
