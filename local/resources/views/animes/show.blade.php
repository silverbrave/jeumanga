@extends('defaut')

@section('css')
    <link href="{{url('style/css/round-about.css')}}" rel="stylesheet">
@endsection
@section('filAriane')
<ol class="breadcrumb" style="margin-top: 20px">
    @foreach($url as $key=>$value)
    <li><a href="{{$value}}">{{$key}}</a></li>
    @endforeach
</ol>
@endsection
@section('content')
    <h1>{{$anime->nom}}</h1>
    <div class="row">
        <div class="col-md-9">
            <img src="{{url('images/imgAnime/'.$anime->imgAnime)}}" alt="" class="img-responsive" style="max-height: 300px">
        </div>
        <div class="col-md-3">
            <h3>Informations</h3>
            <p>Année : {{$anime->annee}}</p>
            <p>Statut : {{$anime->statut}}</p>
            <p>Nombre d'épisodes : {{$anime->nb_ep}}</p>
            <p>Genres :
            @foreach($toto as $genre)
                [{{$genre}}]
            @endforeach
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Synopsis</h3>
            <p style="text-align: justify">{{$anime->synopsis}}</p>
        </div>
    </div>

    {!! Form::open(['route' => ['personnages.create', $anime->id], 'method' => 'get']) !!}
    {!! Form::hidden('idAnime', $anime->id) !!}
    <button type="submit" class="btn btn-primary">Ajouter un personnage</button>
    {!! Form::close() !!}<br>


        <div class="col-lg-12">
            <h2>Les personnages</h2>
        </div>
    <div class="row">
        <h3>Principaux</h3>
        @foreach($persos as $perso)
            @if($perso->role === "principal")
                <div class="col-lg-4 col-sm-6 text-center">
                    <img class="img-circle img-responsive img-center" src="{{url('images/persos/'.$perso->img)}}" alt="" style="width:220px;height:250px;">
                    <h3>{{$perso->prenom}} {{$perso->nom}}</h3>
                    <p>{{$perso->role}}</p>
                    <p>{{$perso->desc}}</p>
                    @if (Illuminate\Support\Facades\Auth::check())
                        <div class="col-md-4" style="padding-top:1.5% ">
                            {!! Form::open(array('route' => array('personnages.destroy', $perso->id), 'method' => 'delete')) !!}
                            {!! Form::hidden('idAnime', $anime->id) !!}
                            <button type="submit"  class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir supprimer ce personnage ?');">Supprimer</button>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-md-4" style="padding-top:1.5% ">
                            <a class="btn btn-warning" href="{{route('personnages.edit',$perso->id)}}">Modifier <span class="glyphicon glyphicon-edit"></span></a>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
        </div>
    <div class="row">
        <h3>Secondaire</h3>
        @foreach($persos as $perso)
            @if($perso->role === "secondaire")
            <div class="col-lg-4 col-sm-6 text-center">
                <img class="img-circle img-responsive img-center" src="{{url('images/persos/'.$perso->img)}}" alt="" style="width:220px;height:250px;">
                <h3>{{$perso->prenom}} {{$perso->nom}}</h3>
                <p>{{$perso->role}}</p>
                <p>{{$perso->desc}}</p>
                @if (Illuminate\Support\Facades\Auth::check())
                    <div class="col-md-4" style="padding-top:1.5% ">
                        {!! Form::open(array('route' => array('personnages.destroy', $perso->id), 'method' => 'delete')) !!}
                        {!! Form::hidden('idAnime', $anime->id) !!}
                        <button type="submit"  class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir supprimer ce personnage ?');">Supprimer</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-4" style="padding-top:1.5% ">
                        <a class="btn btn-warning" href="{{route('personnages.edit',$perso->id)}}">Modifier <span class="glyphicon glyphicon-edit"></span></a>
                    </div>
                @endif
            </div>
                @endif
        @endforeach
        </div>
    <div class="row">
        <h3>Tertiaire</h3>
        @foreach($persos as $perso)
            @if($perso->role === "tertiaire")
            <div class="col-lg-4 col-sm-6 text-center">
                <img class="img-circle img-responsive img-center" src="{{url('images/persos/'.$perso->img)}}" alt="" style="width:220px;height:250px;">
                <h3>{{$perso->prenom}} {{$perso->nom}}</h3>
                <p>{{$perso->role}}</p>
                <p>{{$perso->desc}}</p>
                @if (Illuminate\Support\Facades\Auth::check())
                    <div class="col-md-4" style="padding-top:1.5% ">
                        {!! Form::open(array('route' => array('personnages.destroy', $perso->id), 'method' => 'delete')) !!}
                        {!! Form::hidden('idAnime', $anime->id) !!}
                        <button type="submit"  class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir supprimer ce personnage ?');">Supprimer</button>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-md-4" style="padding-top:1.5% ">
                        <a class="btn btn-warning" href="{{route('personnages.edit',$perso->id)}}">Modifier <span class="glyphicon glyphicon-edit"></span></a>
                    </div>
                    @endif
            </div>
                @endif

        @endforeach
    </div>

@endsection
