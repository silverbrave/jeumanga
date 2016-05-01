@extends('defaut')

@section('css')
    <link href="{{url('style/css/stylePerso.css')}}" rel="stylesheet">
@endsection

@section('content')
<h1>Les animes</h1>
@if (Illuminate\Support\Facades\Auth::check())
    <p><a class="btn btn-primary" href="{{ route('animes.create') }}">Ajouter un Anime</a></p>
@endif
    @foreach($animes as $anime)
        <div class="row">
            <div class="col-md-12" style="background-color: #2e6da4;color:white;">
                <h2><a href="{{url('animes/'.$anime->id)}}" class="lienAnimes">{{$anime->nom}}</a></h2>
            </div>

            <div class="col-md-6">
                <img src="{{url('images/imgAnime/'.$anime->imgAnime)}}" alt="" class="img-responsive">
            </div>
            <div class="col-md-6">
                <p>Année : {{$anime->annee}}</p>
                <p>Synopsis : <br>{{$anime->synopsis}}</p>
            </div>
        </div>
        <hr>

    @endforeach

@endsection
