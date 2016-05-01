@extends('defaut')

@section('content')
    <h1>Ajout d'un genre</h1>

    {!!Form::open(['route' => 'genres.store','method'=>'POST']) !!}

    <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
        {!!Form::label('label', 'Nom *') !!}
        {!!Form::text('nom', null, ['class' => 'form-control','id' =>'nom']) !!}
        @if ($errors->has('nom'))
            <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
        @endif
    </div>
    <button class="btn btn-primary" id="btnEnvoyer">Ajouter</button>
    {!! Form::reset('Effacer') !!}
    {!! Form::close() !!}
@endsection