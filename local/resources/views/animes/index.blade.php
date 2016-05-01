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
        <div class="row" style="background-color: #2e6da4;color:white;">
            <div class="col-md-8">
                <h2><a href="{{url('animes/'.$anime->id)}}" class="lienAnimes">{{$anime->nom}}</a></h2>
            </div>
                @if (Illuminate\Support\Facades\Auth::check())
                    <div class="col-md-2" style="padding-top:1.5% ">
                        {!! Form::open(array('route' => array('animes.destroy', $anime->id), 'method' => 'delete')) !!}
                        <button type="submit"  class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir supprimer cet anime ?');">Supprimer</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-2" style="padding-top:1.5% ">
                        <a class="btn btn-warning" href="{{route('animes.edit',$anime->id)}}">Modifier <span class="glyphicon glyphicon-edit"></span></a>
                    </div>
                @endif

        </div>
        <div class="row">
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
