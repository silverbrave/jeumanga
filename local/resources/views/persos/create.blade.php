@extends('defaut')

@section('content')
    <h1>Ajout d'un personnage</h1>
<div class="col-md-8">
    {!!Form::open(['route' => 'personnages.store','method'=>'POST','files'=> true]) !!}

    <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
        {!!Form::label('label', 'Nom ') !!}
        {!!Form::text('nom', null, ['class' => 'form-control','id' =>'nom']) !!}
        @if ($errors->has('nom'))
            <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
        @endif
    </div>
    <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
        {!!Form::label('label', 'Prénom ') !!}
        {!!Form::text('prenom', null, ['class' => 'form-control','id' =>'prenom']) !!}
        @if ($errors->has('prenom'))
            <span class="help-block">
                                        <strong>{{ $errors->first('prenom') }}</strong>
                                    </span>
        @endif
    </div>
    {{ Form::hidden('idAnime',$idAnime) }}
    <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }}">
        {!!Form::label('label', 'Description ') !!}
        {!!Form::text('desc', null, ['class' => 'form-control','id' =>'desc']) !!}
        @if ($errors->has('desc'))
            <span class="help-block">
                                        <strong>{{ $errors->first('desc') }}</strong>
                                    </span>
        @endif
    </div>

    <button class="btn btn-primary" id="btnEnvoyer">Ajouter</button>
    {!! Form::reset('Effacer') !!}

</div>

@endsection

@section('imageActivite')
    <div class="col-md-4">
        <img id="blah" src="{!! URL::asset('images/troll.png') !!}" alt="" class="img" style="max-height: 300px;max-width: 300px"/>

        <div class="control-group">
            <div class="controls"style="float: right" >
                {!!Form::label('image', 'Image') !!}
                {!! Form::file('img',['class' => 'form-control','id' =>'img']) !!}

                <p class="errors">{!!$errors->first('img')!!}</p>
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


        $("#img").change(function(){
            readURL(this);
        });

    </script>
@stop