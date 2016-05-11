@extends('defaut')

@section('content')


    <div class="col-md-6">
        <h1>Ajout d'un Anime</h1>
        {!!Form::open(['route' => 'animes.store','method'=>'POST', 'files'=> true]) !!}

        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
            {!!Form::label('label', 'Nom') !!}
            {!!Form::text('nom', null, ['class' => 'form-control','id' =>'nom']) !!}
            @if ($errors->has('nom'))
                <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
            @endif
        </div>

         <div class="form-group{{ $errors->has('idgenre') ? ' has-error' : '' }}">
            {!!Form::label('label', 'Genre') !!}
             <p><a class="btn btn-primary" href="{{ route('genres.create') }}">Ajouter un genre</a></p>
             {!! Form::select('idgenre[]',$genres,null, ['class' => 'form-control','id'=>'idgenre','multiple' => 'multiple']) !!}
            @if ($errors->has('idgenre'))
                <span class="help-block">
                                        <strong>{{ $errors->first('idgenre') }}</strong>
                                    </span>
            @endif
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('statut') ? ' has-error' : '' }}">
                {!!Form::label('label', 'Statut') !!}
                {!! Form::select('statut',['En cours' => 'En cours','Terminer'=>'Terminer'], null, ['class' => 'form-control','id'=>'statut']) !!}
                @if ($errors->has('statut'))
                    <span class="help-block">
                <strong>{{ $errors->first('statut') }}</strong>
            </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('difficulte') ? ' has-error' : '' }}">
                {!!Form::label('label', 'Notoriété') !!}
                {!! Form::select('difficulte',['facile' => 'Très connu','moyen'=>'Connu','difficile'=>'Peu ou pas connu'], null, ['class' => 'form-control','id'=>'difficulte']) !!}
                @if ($errors->has('difficulte'))
                    <span class="help-block">
                <strong>{{ $errors->first('difficulte') }}</strong>
            </span>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group{{ $errors->has('nb_ep') ? ' has-error' : '' }}">
                {!!Form::label('label', "Nombre d'épisodes") !!}
                {!!Form::text('nb_ep', null, ['class' => 'form-control','id' =>'nb_ep']) !!}
                @if ($errors->has('nb_ep'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('nb_ep') }}</strong>
                                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('annee') ? ' has-error' : '' }}">
                {!!Form::label('label', 'Année') !!}
                {!!Form::text('annee', null, ['class' => 'form-control','id' =>'annee']) !!}
                @if ($errors->has('annee'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('annee') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('synopsis') ? ' has-error' : '' }}">
            {!!Form::label('label', 'synopsis ') !!}
            {!!Form::textarea('synopsis', null, ['class' => 'form-control','id' =>'synopsis']) !!}
            @if ($errors->has('synopsis'))
                <span class="help-block">
                                        <strong>{{ $errors->first('synopsis') }}</strong>
                                    </span>
            @endif
        </div>

        <button class="btn btn-primary" id="btnEnvoyer">Ajouter</button>
        {!! Form::reset('Effacer') !!}
    </div>

@stop



@section('imageActivite')
    <div class="col-md-4">
        <img id="blah" src="{!! URL::asset('images/troll.png') !!}" alt="" class="img" style="max-height: 300px;max-width: 300px"/>

        <div class="control-group">
            <div class="controls"style="float: right" >
                {!!Form::label('image', 'Image') !!}
                {!! Form::file('imgAnime',['class' => 'form-control','id' =>'imgInp']) !!}

                <p class="errors">{!!$errors->first('imgAnime')!!}</p>
                @if(Session::has('error'))
                    <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>
        </div>
        <img id="blah1" src="{!! URL::asset('images/troll.png') !!}" alt="" class="img" style="max-height: 300px;max-width: 300px"/>
        <div class="control-group">
            <div class="controls"style="float: right" >
                {!!Form::label('image', 'Logo') !!}
                {!! Form::file('logo',['class' => 'form-control','id' =>'imgInp1']) !!}

                <p class="errors">{!!$errors->first('logo')!!}</p>
                @if(Session::has('error'))
                    <p class="errors">{!! Session::get('error') !!}</p>
                @endif
            </div>
        </div>
        <div id="success"> </div>
        {!! Form::close() !!}
    </div>

@stop


@section('script')

    <script type="text/javascript">

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        function readURLbis(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah1').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
        $("#imgInp1").change(function(){
            readURLbis(this);
        });
    </script>
@stop
