<?php

namespace App\Http\Controllers;

use App\Anime;
use Illuminate\Http\Request;

use App\Http\Requests;

class JeuLogoController extends Controller
{
    public function getRandomLogo(){
        $anime =Anime::orderByRaw("RAND()")->first();
        // $anime=Anime::all()->random(1);
        $anime =$anime->getAttributes();
        //pour avoir un element d'anime utilisez la notation ci dessous
         //dd($anime['logo']);

        return compact('anime');
    }


    public function index(){
        $tab=$this->getRandomLogo();
        $anime = $tab['anime'];

        return view('jeulogo.index',compact('anime'));
    }

    public function verifNomLogo(Request $request){

    }
}
