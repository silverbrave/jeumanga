@extends('defaut')

@section('titre')
    Accueil
@endsection
@section('content')
<h1>Accueil</h1>
<div class="col-md-8">
    <h2>News</h2>
    @if(Illuminate\Support\Facades\Auth::check())
        <p><a class="btn btn-primary" href="{{ route('news.create') }}">Ajouter une news <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></p>
    @endif
    @foreach($news as $new)
        <h3>{{$new->titre}}</h3>
        <p>{{$new->desc}}</p>
    @endforeach
</div>
    <div class="col-xs-6 col-md-3">
        <h2>Random Animes</h2>
        <div class="row">
            <a href="{{url('animes/'.$anime['id'])}}"><img src="{{url('images/imgAnime/'.$anime['imgAnime'])}}" alt="" class="img-thumbnail"></a>
        </div>
       <div class="row">
           <h3>{{$anime['nom']}}</h3>
       </div>
    </div>
@endsection
