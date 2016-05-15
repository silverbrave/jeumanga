<?php

namespace App\Http\Controllers;

use App\Anime;
use App\Genre;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class AnimesController extends Controller
{
    public function __construct()
    {
        $stats = $this->getStat();
       return $stats;

    }

    public function index(){
        $animes = Anime::select(DB::raw('animes.*'))
            ->orderBy('nom', 'asc')->get();

       //traitement pour les genres
        foreach($animes as $anime){
            $genres = $anime->idgenre;
            $anime->idgenre =  DB::table('genres')->where('id',intval($anime->idgenre))->pluck('nom');
            $genres = explode(',',$genres);
            $toto =array();
            foreach($genres as $genre){
                $genre = DB::table('genres')->where('id',$genre)->pluck('nom');
                $genre= implode($genre);
                array_push($toto,$genre);
            }
            $anime->idgenre = $toto;
        }
     $stats=$this->__construct();
     //   dd($stats);
        return view('animes.index',compact('animes','stats'));
    }

    public function rechAnime(){
      // dd('toto');
        $query = "select * from `animes` where `nom` like ? order by `nom`";
        $search = '%'.$_POST['rech'].'%';
         //  dd($search);
        $results = DB::select($query , array($search));
       // dd($result);
        return $results;
    }

    public function accueil(){
        $anime =Anime::orderByRaw("RAND()")->first();

        $anime =$anime->getAttributes();
       $stats = $this->getStat();
        //dd($nbAnime);
        return view('index',compact('anime','stats'));
    }


    public function getStat(){
        //tableau contenant les stats
        $stats['nbAnime']= DB::table('animes')->count();
        $stats['nbEpisode']= DB::table('animes')->sum('nb_ep');

        return $stats;
    }
    public function create(){
        $stats=$this->__construct();
        $genres= Genre::lists('nom', 'id');
        return view('animes.create',compact('genres','stats'));
    }

    public function store(Request $request){
       // dd($request->all());

        //validation des infos rentrées ds le formulaire
        $this->validate($request, [
            'nom' => 'required|string|max:255',
            'idgenre' => 'required',
            'statut' => 'required',
            'difficulte' => 'required',
            'annee' => 'required',
            'synopsis' => 'required',
            'nb_ep' => 'required|integer',
        ]);


        $nom = ucwords($request->get('nom'));
        $genres = implode(',',$request->get('idgenre'));
        $annee =(int)$request->get('annee');
        if (Input::hasFile('imgAnime')) {
            $imgName = Input::file('imgAnime')->getClientOriginalName();
            Input::file('imgAnime')->move('images/imgAnime', $imgName);
            if (Input::hasFile('logo')) {
                $imgNameBis = Input::file('logo')->getClientOriginalName();
                Input::file('logo')->move('images/logo', $imgNameBis);
            }
            else{
                $imgNameBis='troll2.png';
            }
            if (Anime::create(['nom' => $nom, 'nb_ep' =>$request->get('nb_ep'), 'synopsis' => $request->get('synopsis'), 'imgAnime' => $imgName, 'logo' => $imgNameBis,'op'=> "",'idgenre'=> $genres,'annee'=>$annee,'statut'=>$request->get('statut'),'difficulte'=>$request->get('difficulte')])) {
                Session::flash('flash_message', "L'Anime a bien été créé!");
                    return redirect(route('animes.index'));
                } else {
                    return redirect(route('animes.create'))->withInput();
                }

        } else {
            $imgName = 'troll.png';
            if (Input::hasFile('logo')) {
                $imgNameBis = Input::file('logo')->getClientOriginalName();
                Input::file('logo')->move('images/logo', $imgNameBis);
            }
            else{
                $imgNameBis='troll2.png';
            }
            if (Anime::create(['nom' => $nom, 'nb_ep' =>$request->get('nb_ep'), 'synopsis' => $request->get('synopsis'), 'imgAnime' => $imgName, 'logo' => $imgNameBis,'op'=> "",'idgenre'=> $genres,'annee'=>$annee,'statut'=>$request->get('statut')])) {
                Session::flash('flash_message', "L'Anime a bien été créé!");
                return redirect(route('animes.index'));
            } else {
                return redirect(route('animes.create'))->withInput();

            }
        }

    }

    public function show($id){
        $stats=$this->__construct();

        $anime = Anime::findOrFail($id);
        $persos = DB::table('personnages')->where('idAnime',$id)->get();

        //fil d'ariane pour le moment
        $url= $_SERVER['REQUEST_URI'];
        $onglets = explode('/',$url);
       $onglets= array_splice($onglets,1,count($onglets));
       $onglets[0]="Accueil";
        $url=[];
      foreach($onglets as $onglet){
          if(strcasecmp($onglet,"Accueil")==0){
              $tmp = url('/');
            $url['Accueil'] = $tmp;
          }
          else if(strcasecmp($onglet,"animes")==0){
              $tmp = url('/animes');
              $url['animes'] = $tmp;
          }
            else{
                $tmp = url('/animes/'.$onglet);
                $url[$onglet] = $tmp;
            }
      }

        //traitements pour les differents genres d'un anime
        $genres = $anime->idgenre;
        $anime->idgenre =  DB::table('genres')->where('id',intval($anime->idgenre))->pluck('nom');

        $genres = explode(',',$genres);
        $toto =array();
        foreach($genres as $genre){
            $genre = DB::table('genres')->where('id',$genre)->pluck('nom');
            $genre= implode($genre);
            array_push($toto,$genre);
        }

        return(view('animes.show',compact('anime','persos','url','toto','stats')));
    }

    public function destroy($id)
    {
        $anime = Anime::findOrFail($id);
        $anime->delete();
        Session::flash('flash_message', "L'Anime a bien été supprimé!");
        return redirect(route('animes.index'));

    }

    public function edit($id){
        $stats=$this->__construct();
        $anime = Anime::findOrFail($id);
        $genres= Genre::lists('nom', 'id');
        return view('animes.edit',compact('anime','genres','stats'));
    }

    public function update($id,Request $request){

        $anime = Anime::findOrFail($id);

        $nom = ucwords($request->get('nom'));
        $genres = implode(',',$request->get('idgenre'));
        $annee =(int)$request->get('annee');
        if (Input::hasFile('imgAnime')) {
            $imgName = Input::file('imgAnime')->getClientOriginalName();
            Input::file('imgAnime')->move('images/imgAnime', $imgName);
            if (Input::hasFile('logo')) {
                $imgNameBis = Input::file('logo')->getClientOriginalName();
                Input::file('logo')->move('images/logo', $imgNameBis);
            }
            else{
                $imgNameBis='troll2.png';
            }
            if ($anime->update(['nom' => $nom, 'nb_ep' =>$request->get('nb_ep'), 'synopsis' => $request->get('synopsis'), 'imgAnime' => $imgName, 'logo' => $imgNameBis,'op'=> "",'idgenre'=> $genres,'annee'=>$annee,'statut'=>$request->get('statut'),'difficulte'=>$request->get('difficulte')])) {
                Session::flash('flash_message', $anime->nom." a bien été modifié!");
                return redirect(route('animes.index'));
            } else {
                return redirect(route('animes.edit',$anime->id))->withInput();
            }

        } else {
            $imgName = 'troll.png';
            if (Input::hasFile('logo')) {
                $imgNameBis = Input::file('logo')->getClientOriginalName();
                Input::file('logo')->move('images/logo', $imgNameBis);
            }
            else{
                $imgNameBis='troll2.png';
            }
            if ($anime->update(['nom' => $nom, 'nb_ep' =>$request->get('nb_ep'), 'synopsis' => $request->get('synopsis'), 'imgAnime' => $imgName, 'logo' => $imgNameBis,'op'=> "",'idgenre'=> $genres,'annee'=>$annee,'statut'=>$request->get('statut')])) {
                Session::flash('flash_message', $anime->nom." a bien été modifié!");
                return redirect(route('animes.index'));
            } else {
                return redirect(route('animes.edit',$anime->id))->withInput();

            }
        }

    }
}
