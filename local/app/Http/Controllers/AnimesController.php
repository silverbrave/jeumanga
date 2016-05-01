<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;

use App\Http\Requests;

class AnimesController extends Controller
{
    public function index(){
        return view('animes.index');
    }

    public function create(){
        $genres= Genre::lists('nom', 'id');
        return view('animes.create',compact('genres'));
    }

    public function store(Request $request){

    }
}
