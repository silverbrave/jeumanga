@extends('defaut')
@section('css')
    <link href="{{url('style/css/jeuPerso.css')}}" rel="stylesheet">
@endsection
@section('content')
    <h1>JEU SUR LES PERSONNAGES</h1>
    <div class="col-md-2"></div>
    <div class="col-md-5" id="jeu">
        <h3>Entrez le nom de l'Anime qui correspond au logo</h3>
        <img src="{{url('images/logo/'.$anime['logo'])}}" alt="" class="img-responsive" id="imgAnime">
        <div class="form-group" id="divform">

            {!!Form::open(['route'=>'verifLogo','method'=>'POST','id'=>'formPerso']) !!}
            {!!Form::text('nom', null, ['class' => 'form-control','id' =>'nom']) !!}
            <span class="help-block" id="msgErreur">
                        <strong></strong>
                    </span>
            @if ($errors->has('nom'))
                <span class="help-block">
                        <strong>{{ $errors->first('nom') }}</strong>
                    </span>
            @endif
        </div>
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-6">
                {!! Form::submit('Valider',['class'=>'btn btn-primary','id'=>'btnValider'])!!}
            </div>
        </div>

        {!! Form::close() !!}


    </div>
    <div class="col-md-3" id="score">
        <h3>Informations</h3>
        <h4>Score:</h4><p id="valScore">0</p>
        <h4>Vies:</h4>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                <span class="sr-only">40% Complete (success)</span>
                <p id="valVie">5</p>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var nomAnimeF= "{{$anime['nom']}}";

            $('#formPerso').on('submit',function(e){

                var score = $('#valScore').text();
                var vie = $('#valVie').text();
//le probleme est ici vu qu'on utilise les var pghp
                var nomAnimeR = $('#nom').val();
                nomAnimeR = nomAnimeR.toLowerCase();
                console.log('nom anime rentre : '+nomAnimeR);

                var nomRef = nomAnimeF;
                nomRef = nomRef.toLowerCase();
                console.log('nom da anime ref : '+nomRef);



                var token = $("[name=_token]").val();
                console.log(token);
                $.ajaxSetup({
                    header:$('meta[name="_token"]').attr('content')
                });


                //var data = $(this).serialize();
                var data = {
                    "nom":nomAnimeR,
                    "nomRef":nomRef,
                    "_token":token
                };
                var url  = $(this).attr('action');
                console.log(url);
                $.ajax({
                    type:"POST",
                    url: url,
                    data:data,
                    dataType: 'json',
                    success: function(data){
                        console.log("succes");
                        //console.log(data['win']);
                        if(data['win']==="true"){
                            console.log('win');
                            var anime = data['anime'];
                         //   var perso = data['perso'];

                            //nomF=data['perso'].nom;
                           // prenomF=data['perso'].prenom;

                           // console.log(data['perso'].img);
                            //$('#imgAnime').src=data['anime'].imgAnime;
                            var image = "{{url('images/logo/')}}"+'/'+data['logo'].img;
                          //  console.log(image);
                           // $("#imgAnime").attr("src",image);
                           // score=parseInt(score);
                           // score =score+1;
                           // console.log(score);


                            if(score===5 && vie > 0){
                                alert("GG, Partie terminée!");
                            }
                           // $('#valScore').text(score);
                           // $('#msgErreur').text("Bien joué! Place au personnage suivant");
                            //$("#divform").attr("class",'form-group has-success');
                           // $('#nom').val("");
                        }
                        else{
                           // vie=parseInt(vie);
                           // vie =vie-1;
                           // console.log(vie);
                          //  $('#valVie').text(vie);
                          //  $("#divform").attr("class",'form-group has-error');
                          //  $('#msgErreur').text("ce n'est pas le bon personnage");
                        }
                    },
                    error: function(data){
                        console.log("echec");
                        // console.log(data[0]);
                    }
                });
                e.preventDefault(e);
            });
        });


    </script>
@endsection