@extends('defaut')

@section('content')
    <h1>Modification du personnage : {{$perso->nom}}</h1>
    <div class="col-md-8">
        {!!Form::open(['method' => 'PUT','url' => route('personnages.update',$perso->id),'files'=> true]) !!}

        <div class="form-group{{ $errors->has('nom') ? ' has-error' : '' }}">
            {!!Form::label('label', 'Nom ') !!}
            {!!Form::text('nom', $perso->nom, ['class' => 'form-control','id' =>'nom']) !!}
            @if ($errors->has('nom'))
                <span class="help-block">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('prenom') ? ' has-error' : '' }}">
            {!!Form::label('label', 'Prénom ') !!}
            {!!Form::text('prenom', $perso->prenom, ['class' => 'form-control','id' =>'prenom']) !!}
            @if ($errors->has('prenom'))
                <span class="help-block">
                                        <strong>{{ $errors->first('prenom') }}</strong>
                                    </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
            {!!Form::label('label', 'Rôle ') !!}
            <label>
                {!!Form::radio('role', 'principal',null,['class'=>'radio radio-inline','id'=>'roleP'])!!}
                Principal
            </label>

            <label>
                {!!Form::radio('role', 'secondaire',null,['class'=>'radio radio-inline','id'=>'roleS'])!!}
                Secondaire
            </label>

            <label>
                {!!Form::radio('role', 'tertiaire',null,['class'=>'radio radio-inline','id'=>'roleT'])!!}
                Tertiaire
            </label>

            @if ($errors->has('role'))
                <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
            @endif
        </div>
        {{ Form::hidden('idAnime',$idAnime) }}
        <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }}">
            {!!Form::label('label', 'Description ') !!}
            {!!Form::textarea('desc', $perso->desc, ['class' => 'form-control','id' =>'desc']) !!}
            @if ($errors->has('desc'))
                <span class="help-block">
                    <strong>{{ $errors->first('desc') }}</strong>
                </span>
            @endif
        </div>

        <button class="btn btn-primary" id="btnEnvoyer">Modifier</button>
        {!! Form::reset('Effacer') !!}

    </div>

@endsection

@section('imageActivite')
    <div class="col-md-4">
        <img id="blah" src="{!! url('images/persos/'.$perso->img)!!}" alt="" class="img" style="max-height: 300px;max-width: 300px"/>

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

        $(document).ready(function() {
            var role = "{{$perso->role}}";
            if(role==="principal"){
                $('#roleP').prop('checked',true);
            }
            else if(role==="secondaire"){
                $('#roleS').prop('checked',true);
            }
            else{
                $('#roleT').prop('checked',true);
            }


            $("#img").change(function(){
                readURL(this);
            });
        });


    </script>
@stop