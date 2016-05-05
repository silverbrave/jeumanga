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
    public function index(){
        $animes = Anime::select(DB::raw('animes.*'))
            ->orderBy('created_at', 'desc')->get();

        return view('animes.index',compact('animes'));
    }

    public function create(){
        $genres= Genre::lists('nom', 'id');
        return view('animes.create',compact('genres'));
    }

    public function store(Request $request){
       // dd($request->all());

        $nom = ucwords($request->get('nom'));
        $genres = implode(',',$request->get('idgenre'));
      //  $annee =intval($request->get('annee'));
        $annee =(int)$request->get('annee');
        //dd(is_int($annee));
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
            if (Anime::create(['nom' => $nom, 'nb_ep' =>$request->get('nb_ep'), 'synopsis' => $request->get('synopsis'), 'imgAnime' => $imgName, 'logo' => $imgNameBis,'op'=> "",'idgenre'=> $genres,'annee'=>$annee,'statut'=>$request->get('statut')])) {
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
        $anime = Anime::findOrFail($id);
        $persos = DB::table('personnages')->where('idAnime',$id)->get();

        //fil d'ariane pour le moment
        $url= $_SERVER['REQUEST_URI'];
        $onglets = explode('/',$url);
       $onglets= array_splice($onglets,1,count($onglets));
      // $onglets[0]="Accueil";
       //    dd($onglets);
        return(view('animes.show',compact('anime','persos','onglets')));
    }

    public function destroy($id)
    {
        $anime = Anime::findOrFail($id);
        $anime->delete();
        Session::flash('flash_message', "L'Anime a bien été supprimé!");
        return redirect(route('animes.index'));

    }
}
