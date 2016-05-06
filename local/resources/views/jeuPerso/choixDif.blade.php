@extends('defaut')
@section('content')
    <h1>Sélectionnez une difficulté</h1>
    <div class="col-md-2"></div>
    <div class="col-md-9">
        {!!Form::open(['route'=>'indexJeuPerso','method'=>'GET','id'=>'formDif']) !!}
        <div class="radio-inline">
            <label>
                <img src="{{url('images/persos/naruto.png')}}" alt="" class="img-circle img-responsive img-center" style="width:220px;height:250px">
                {!!Form::radio('difficulte', 'Facile',['class'=>'radio'])!!}
               <p>Facile</p>
            </label>
        </div>
        <div class="radio-inline">
            <label>
                <img src="{{url('images/persos/eishirou.png')}}" alt="" class="img-circle img-responsive img-center" style="width:220px;height:250px">
                {!!Form::radio('difficulte', 'Moyen',['class'=>'radio'])!!}
                <p>Moyen</p>
            </label>
        </div>
        <div class="radio-inline">
            <label>
                <img src="{{url('images/persos/286632.jpg')}}" alt="" class="img-circle img-responsive img-center" style="width:220px;height:250px">
                {!!Form::radio('difficulte', 'Hardcore',['class'=>'radio'])!!}
                <p>Hardcore</p>
            </label>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-5">
                {!! Form::submit('Valider',['class'=>'btn btn-primary','id'=>'btnValider'])!!}
            </div>
        </div>


        {!! Form::close() !!}
    </div>
@endsection