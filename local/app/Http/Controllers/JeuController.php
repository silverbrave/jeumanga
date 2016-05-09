<?php

namespace App\Http\Controllers;

use App\Anime;
use App\Personnage;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class JeuController extends Controller
{

    //public $tabPersoDejaVu=array(array());
    public $tabPersoDejaVu=array();

    public function getRandomPerso(){
        $dif = Input::get('difficulte');

        if(isset($dif)){
            dd($dif);
            $anime =Anime::orderByRaw("RAND()")->first();
            // $anime=Anime::all()->random(1);
            $anime =$anime->getAttributes();
            //pour avoir un element d'anime utilisez la notation ci dessous
            // dd($anime['id']);
            $perso=Personnage::orderByRaw("RAND()")->where('idAnime',$anime['id'])->where('role',$dif)->first();
            $tab=compact('anime','perso');
            $anime = $tab['anime'];
            $perso = $tab['perso'];
        }else{
            $anime =Anime::orderByRaw("RAND()")->first();
            // $anime=Anime::all()->random(1);
            $anime =$anime->getAttributes();
            //pour avoir un element d'anime utilisez la notation ci dessous
            // dd($anime['id']);
            $perso=Personnage::orderByRaw("RAND()")->where('idAnime',$anime['id'])->first();
            $perso = $perso->getAttributes();
        }

         return compact('anime','perso');
    }

    //inutile a mon avis
 public function getRandomPersoDif($dif){

        $anime =Anime::orderByRaw("RAND()")->first();
       // $anime=Anime::all()->random(1);
        $anime =$anime->getAttributes();
        //pour avoir un element d'anime utilisez la notation ci dessous
       // dd($anime['id']);

     $perso=Personnage::orderByRaw("RAND()")->where('role',$dif)->first();
     $anime =  DB::table('animes')->where('id',$perso['idAnime'])->first();
     //dd($anime);
    if(empty($perso)){
        $this->getRandomPersoDif($dif);
    }
         return compact('anime','perso');
    }


    public function index(){
        $dif=Input::get('difficulte');
        if(isset($dif)){
           // dd($dif);
            $tab=$this->getRandomPersoDif($dif);
            $anime = $tab['anime'];
            $perso = $tab['perso'];
         //   Session::put('persoDejaVu',[]);
            return compact('anime','perso');
        }else{
            $tab=$this->getRandomPerso();
            $anime = $tab['anime'];
            $perso = $tab['perso'];
            Session::put('persoDejaVu',[]);
            return view('jeuPerso.index',compact('anime','perso'));
        }
        //$_SESSION['persoDejaVu']=[];

    }

      public function indexDif(){
        return view('jeuPerso.choixDif');
    }



    public function verifNom(Request $request){
       //dd($request->all());
        //dd(Session::get('persoDejaVu'));

        $nomRentrer = $request->get('nom');

        $prenomRef = $request->get('prenomPerso');
        $nomRef = $request->get('nomRef');
        $animeOld = $request->get('anime');

        $win = "false";

        //cdt pour win : nom ||prenom == nomRentrer par l'utilisateur
        if((strcasecmp($nomRentrer,$nomRef)==0 || strcasecmp($nomRentrer,$prenomRef)==0)){
            $win="true";

            $nouvPersoA=strtolower($nomRef)." ".strtolower($prenomRef);

            Session::push('persoDejaVu', $nouvPersoA);
           //dd(Session::get('persoDejaVu'));

            //on cherche un nouveau perso
            $tab=$this->getRandomPerso();
            $anime = $tab['anime'];
            $perso = $tab['perso'];

            $nouvPersoR=strtolower($perso['nom'])." ".strtolower($perso['prenom']);

            //on verifie que le nouveau perso soit different de l'ancien et que l'on ne l'a pas encore rencontré

            if(in_array($nouvPersoR,Session::get('persoDejaVu'))==true){
               // dd(Session::get('persoDejaVu'));
                $this->verifNom($request);
            }


          /*  if(strcasecmp($perso['nom'],$nomRef)==0 || strcasecmp($perso['prenom'],$prenomRef)==0){
              // dd('efz');
                if(array_search($nomRef,$tabPersoDejaVu)==true){
                    $this->verifNom($request);
                }

            }*/
          //  dd($perso['nom']);
           // Session::flash('flash_message', "Bien joué! Place au personnage suivant.");
            return compact('win','anime','perso');
        }
        else
        {

            return $win;
        }

    }
}
