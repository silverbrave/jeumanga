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
    //public $tabPersoDejaVu=array(array());
    public $tabPersoDejaVu=array();
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

        //[0]->nom [1]->prenom
       // $localTab= $this->tabPersoDejaVu;

        $nomRentrer = $request->get('nom');
        //dd($nom);
        $prenomRef = $request->get('prenomPerso');
        $nomRef = $request->get('nomRef');
        $animeOld = $request->get('anime');

        //$tabPersoDejaVu=[];
        $win = "false";

        //cdt pour win : nom ||prenom == nomRentrer par l'utilisateur
        if((strcasecmp($nomRentrer,$nomRef)==0 || strcasecmp($nomRentrer,$prenomRef)==0)){

            $win="true";
           // dd('win');
            //on ajoute le perso deja vu au tableau
          /*  $this->tabPersoDejaVu=array(array('nom'=>$nomRef,
                            'prenom'=>$prenomRef
                            ));*/
            /*$nouvPersoA = array('nom'=>$nomRef,
                'prenom'=>$prenomRef
            );*/
            $nouvPersoA=$nomRef." ".$prenomRef;
           // dd($nouvPersoA);
            array_push($this->tabPersoDejaVu,$nouvPersoA);
            //dd($this->tabPersoDejaVu);
            /*$tabPersoDejaVu['nom']=$nomRef;
            $tabPersoDejaVu['prenom']=$prenomRef;*/

            //on cherche un nouveau perso
            $tab=$this->getRandomPerso();
            $anime = $tab['anime'];
            $perso = $tab['perso'];
           /* $nouvPersoR = array('nom'=>$perso['nom'],
                'prenom'=>$perso['prenom']
            );*/
            $nouvPersoR=strtolower($perso['nom'])." ".strtolower($perso['prenom']);
            //array_push($this->tabPersoDejaVu,$nouvPersoR);
          // dd($this->tabPersoDejaVu);
            //on verifie que le nouveau perso soit different de l'ancien et que l'on ne l'a pas encore rencontré

            if(in_array($nouvPersoR,$this->tabPersoDejaVu)==true){
                dd('enfin trouve in_array');
            }
            if(array_search($perso['nom'],$this->tabPersoDejaVu)!=false && array_search($perso['prenom'],$this->tabPersoDejaVu)){
                dd('areizo array_search1');

            }

                if(array_search($perso['nom'],array_column($this->tabPersoDejaVu,'nom'))!=false && array_search($perso['prenom'],array_column($this->tabPersoDejaVu,'prenom'))){
                dd('dejatrouve array_search2');
                dd($this->tabPersoDejaVu);
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
