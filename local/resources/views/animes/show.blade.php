@extends('defaut')

@section('content')
    <h1>{{$anime->nom}}</h1>
    <div class="col-md-12">
        <img src="{{url('images/imgAnime/'.$anime->imgAnime)}}" alt="" class="img-responsive">
    </div>

@endsection