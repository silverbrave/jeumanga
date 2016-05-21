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
    //public $tabPersoDejaVu=array();

    public function getRandomPerso($dif){
        $persoDejaVu = Session::get('PersoDejaVu');

        if(isset($dif)){
            //cherche un random anime avec la dif passé en parametre
            $perso=Personnage::orderByRaw("RAND()")->where('role',$dif)->first();

            $anime =  DB::table('animes')->where('id',$perso['idAnime'])->first();


            $persoDejaVu = Session::get('PersoDejaVu');
            //   dd($animeDejaVu);
            $nbPerso =  DB::table('personnages')->where('role',$dif)->count();
            //    dd($nbAnime);
            $cdt = false;
            $i=1;
            while ($i<=$nbPerso && $cdt!=true) {
                if (in_array($perso['nom'], $persoDejaVu)) {
                    $perso=Personnage::orderByRaw("RAND()")->where('role',$dif)->first();
                    $perso = $perso->getAttributes();
                    $anime =  DB::table('animes')->where('id',$perso['idAnime'])->first();
                    $i++;
                }
                else{
                    $cdt =true;
                    Session::push('PersoDejaVu', $perso['nom']);
                    return compact('anime','perso');
                }
            }
        }
        else{
            //cherche un random anime sans dif
            $perso=Personnage::orderByRaw("RAND()")->first();
            $perso = $perso->getAttributes();
            $anime =  DB::table('animes')->where('id',$perso['idAnime'])->first();
          //  $anime = $anime->getAttributes();
            // dd($anime['nom']);
            return compact('anime','perso');
        }


    }



    public function index(){
        $dif=Input::get('difficulte');
        if(isset($dif)){
           // dd($dif);
            $tab=$this->getRandomPerso($dif);
            $anime = $tab['anime'];
            $perso = $tab['perso'];
         //   Session::put('persoDejaVu',[]);
            return compact('anime','perso');
        }else{
            $dif=null;
            Session::put('PersoDejaVu',[]);
            $tab=$this->getRandomPerso($dif);
            $anime = $tab['anime'];
            $perso = $tab['perso'];

            //--- A RETENIR ----
        //   dd($perso['nom']);
         //   dd($anime->nom);
            return view('jeuPerso.index',compact('anime','perso'));
        }
        //$_SESSION['persoDejaVu']=[];

    }



    public function verifNom(Request $request){
     //  dd($request->all());
        //dd(Session::get('persoDejaVu'));

        $difficulte = $request->get('difficulte');
        $nomRentrer = $request->get('nom');

        $prenomRef = $request->get('prenomPerso');
        $nomRef = $request->get('nomRef');
        $animeOld = $request->get('anime');

        $win = "false";

        //cdt pour win : nom ||prenom == nomRentrer par l'utilisateur
        if((strcasecmp($nomRentrer,$nomRef)==0 || strcasecmp($nomRentrer,$prenomRef)==0)){
            $win="true";

            $nouvPersoA=strtolower($nomRef)." ".strtolower($prenomRef);

         //   Session::push('persoDejaVu', $nouvPersoA);
           //dd(Session::get('persoDejaVu'));

            //on cherche un nouveau perso
            $tab=$this->getRandomPerso($difficulte);
            $anime = $tab['anime'];
            $perso = $tab['perso'];

            $nouvPersoR=strtolower($perso['nom'])." ".strtolower($perso['prenom']);

            //on verifie que le nouveau perso soit different de l'ancien et que l'on ne l'a pas encore rencontré

         /*   if(in_array($nouvPersoR,Session::get('persoDejaVu'))==true){
               // dd(Session::get('persoDejaVu'));
                $this->verifNom($request);
            }*/


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
