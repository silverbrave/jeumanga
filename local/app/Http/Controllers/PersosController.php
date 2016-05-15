<?php

namespace App\Http\Controllers;

use App\Personnage;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class PersosController extends Controller
{
    public function create(){
        $idAnime= Input::get('idAnime');
        return view('persos.create',compact('idAnime'));
    }
    public function store(Request $request){

        //dd($request->all());
        $nom = ucwords($request->get('nom'));
        $prenom = ucwords($request->get('prenom'));
        $idAnime = $request->get('idAnime');
        if (Input::hasFile('img')) {
            $imgName = Input::file('img')->getClientOriginalName();

            if (Personnage::create(['idAnime'=> $idAnime,'nom' => $nom, 'prenom' => $prenom, 'img' =>$imgName,'desc' => $request->get('desc'),'role'=>$request->get('role')])) {
                Input::file('img')->move('images/persos/', $imgName);
                Session::flash('flash_message', "Le Personnage a bien été créé!");
                return redirect(route('animes.show',$idAnime));
            } else {
                return redirect(route('personnage.create'))->withInput();
            }
        }
        else{
            $imgName = 'troll.png';
            if (Personnage::create(['idAnime'=> $idAnime,'nom' => $nom, 'prenom' => $prenom, 'img' =>$imgName,'desc' => $request->get('desc'),'role'=>$request->get('role')])) {
                Session::flash('flash_message', "Le Personnage a bien été créé!");
                return redirect(route('animes.show',$idAnime));
            } else {
                return redirect(route('personnage.create'))->withInput();
            }
        }
    }

    public function destroy($id)
    {
        $idAnime= Input::get('idAnime');
        $perso = Personnage::findOrFail($id);
        $perso->delete();
        Session::flash('flash_message', "Le Personnage a bien été supprimé!");
        return redirect(route('animes.show',$idAnime));

    }

    public function edit($id){
        $perso = Personnage::findOrFail($id);
        $idAnime= Input::get('idAnime');
        return view('persos.edit',compact('perso','idAnime'));
    }

    public function update($id,Request $request){
        $idAnime = $request->get('idAnime');
        $perso = Personnage::findOrFail($id);
       // $perso->update($request->all());

        $nom = ucwords($request->get('nom'));
        $prenom = ucwords($request->get('prenom'));

        if (Input::hasFile('img')) {
            $imgName = Input::file('img')->getClientOriginalName();

            if ($perso->update(['idAnime'=> (int)$idAnime,'nom' => $nom, 'prenom' => $prenom, 'img' =>$imgName,'desc' => $request->get('desc'),'role'=>$request->get('role')])) {
                Input::file('img')->move('images/persos/', $imgName);
                Session::flash('flash_message', $perso->nom." a bien été modifié!");
                return redirect(route('animes.show',$idAnime));
            } else {
                return redirect(route('personnage.create'))->withInput();
            }
        }
        else{
            $imgName = 'troll.png';
            if ($perso->update(['idAnime'=> (int)$idAnime,'nom' => $nom, 'prenom' => $prenom, 'img' =>$imgName,'desc' => $request->get('desc'),'role'=>$request->get('role')])) {
                Session::flash('flash_message', $perso->nom." a bien été modifié!");
                return redirect(route('animes.show',$idAnime));
            } else {
                return redirect(route('personnage.create'))->withInput();
            }
        }

    }
}
