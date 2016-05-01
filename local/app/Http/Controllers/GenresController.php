<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;

use App\Http\Requests;

class GenresController extends Controller
{
    public function create(){
        return view('genres.create');
    }

    public function store(Request $request ){
        $nom = ucwords($request->get('nom'));
        if(Genre::create(['nom'=>$nom])){
            return redirect(route('animes.create'));
        }
       else{
           return redirect(route('genres.create'))->withInput();
       }
    }
}
