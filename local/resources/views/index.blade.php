@extends('defaut')

@section('titre')
    Accueil
@endsection
@section('content')
<h1>Accueil</h1>

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
