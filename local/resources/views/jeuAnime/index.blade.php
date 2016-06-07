@extends('defaut')
@section('titre')
    Quiz Animes
@endsection
@section('css')
    <link href="{{url('style/css/jeuPerso.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css">
@endsection
@section('content')
    <h1>Jeu sur les animes</h1>

    <div class="row">
        <div class="col-md-9" id="divDifficulte">
            {!!Form::open(['route'=>'verifAnime','method'=>'GET','id'=>'formDif']) !!}
            <div class="radio-inline">
                <label>
                    <img src="{{url('images/persos/naruto.png')}}" alt="" class="img-circle img-responsive img-center" style="width:220px;height:250px">
                    {!!Form::radio('difficulte', 'facile',['class'=>'radio'])!!}
                    <p>Facile</p>
                </label>
            </div>
            <div class="radio-inline">
                <label>
                    <img src="{{url('images/persos/eishirou.png')}}" alt="" class="img-circle img-responsive img-center" style="width:220px;height:250px">
                    {!!Form::radio('difficulte', 'moyen',['class'=>'radio'])!!}
                    <p>Moyen</p>
                </label>
            </div>
            <div class="radio-inline">
                <label>
                    <img src="{{url('images/persos/286632.jpg')}}" alt="" class="img-circle img-responsive img-center" style="width:220px;height:250px">
                    {!!Form::radio('difficulte', 'difficile',['class'=>'radio'])!!}
                    <p>Hardcore</p>
                </label>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-5">
                    {!! Form::submit('Valider',['class'=>'btn btn-primary','id'=>'btnValDif'])!!}
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-md-2" id="listeAnime">
        <h3>Animes déjà trouvé</h3>
        <div id="animeT"></div>
    </div>
    <div class="col-md-6" id="jeu">
        <h3>Entrez le nom de l'Anime</h3>
        <img src="{{url('images/imgAnime/'.$anime['imgAnime'])}}" alt="" class="img-responsive" id="imgAnime" style="z-index:1;max-width: 500px;max-height: 500px">
        <img src="{{url('images/score/score++.gif')}}" alt="" style="position:absolute;z-index:999;width: 150px;display: none" class="" id="upScore">
        <img src="{{url('images/score/vie--.gif')}}" alt="" style="position:absolute;z-index:999;width: 150px;display: none" class="" id="downVie">
        <div class="form-group" id="divform">

            {!!Form::open(['route'=>'verifAnime','method'=>'POST','id'=>'formPerso']) !!}
            {!!Form::text('nom', null, ['class' => 'form-control','id' =>'nom', 'autocomplete'=>"off" ]) !!}
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
        <h4>Score:</h4><p id="valScore" >0</p>

        <h4>Vies:</h4>
        <div class="progress">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%" id="barreVie">
                <span class="sr-only">40% Complete (success)</span>
                <p id="valVie">4</p>
            </div>
        </div>

        <p><a href="{{url('/quizAnimes')}}" class="btn btn-danger">Recommencer</a></p>
        <div id="popupconfirmation" title="Titre de la fenêtre" class="modal-dialog modal-sm" style="display: none">
            <p>Voulez vous recommencez la partie?</p>
        </div>
        <div id="popupwin" title="Titre de la fenêtre" class="modal-dialog modal-sm" style="display: none">
            <p>GG, La partie est terminée, recommence avec une autre difficulté!</p>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var nomF= "{{$anime['nom']}}";
            var imgF= "{{$anime['imgAnime']}}";
            //on cache les div du jeu et du score
            $('#jeu').hide();
            $('#listeAnime').hide();
            $('#score').hide();
            dif=null;

            $('#formDif').on('submit',function(e){
                var difficulte = $("input[name='difficulte']:checked").val();
                dif=difficulte;
                console.log(difficulte);

                //   console.log(test);
                $('#divDifficulte').hide();
                $.ajaxSetup({
                    header:$('meta[name="_token"]').attr('content')
                });
                var token = $("[name=_token]").val();
                var data = {
                    "difficulte":difficulte,
                    "_token":token
                };
                var url  ="{{route('indexJeuAnime')}}";
                console.log(url);
                $.ajax({
                    type:"GET",
                    url: url,
                    data:data,
                    dataType: 'json',
                    success: function(data){
                        console.log("success au choix dif");

                        var anime = data['anime'];
                        var perso = data['perso'];
                        nomF=data['nom'];
                        imgF = data['imgAnime'];
                       // prenomF=data['perso'].prenom;
                        var imag = "{{url('images/imgAnime/')}}"+'/'+data['imgAnime'];
                        $("#imgAnime").attr("src",imag);
                        $('#jeu').fadeToggle('fast');
                        $('#score').fadeToggle('slow');
                        $('#listeAnime').fadeToggle('slow');
                    },
                    error: function(data){
                        console.log("echec");
                        // console.log(data[0]);
                    }
                });
                e.preventDefault(e);

            });



            //a changer si on veut desactiver le bouton valider
            $('#btnValider').prop("disabled",false);


            $('#nom').on('change',function(){
                if($('#nom').val()===""){
                    $("#divform").attr("class",'form-group has-error');
                    $('#msgErreur').text("Vous n'avez saisi aucun nom ou prenom");
                    $('#btnValider').prop("disabled",true);
                }
                else{
                    $('#btnValider').prop("disabled",false);
                }
            });



            $('#formPerso').on('submit',function(e){

                var score = $('#valScore').text();
                var vie = $('#valVie').text();
//le probleme est ici vu qu'on utilise les var pghp
                var nomAnimeRentre = $('#nom').val();
                nomAnimeRentre = nomAnimeRentre.toLowerCase();
                console.log('nom du perso rentre : '+nomAnimeRentre);

                var nomRef = nomF;
                var imgRef = imgF;
                nomRef = nomRef.toLowerCase();
                console.log('nom du peros ref : '+nomRef);

             //   var prenomRef = prenomF;

                var token = $("[name=_token]").val();
                //console.log(token);
                $.ajaxSetup({
                    header:$('meta[name="_token"]').attr('content')
                });

                var data = {
                    "nom":nomAnimeRentre,
                    "nomRef":nomRef,
                    "difficulte":dif,
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
                     //   console.log(data['win']);
                        if(data['win']==="true"){
                            console.log('win');

                            $('#upScore').show('slow');
                            $('#upScore').hide(500);
                            if (data.anime===null){
                                console.log('plus danime');
                                var im = "{{url('images/score/troll.png')}}";
                                $("#imgAnime").attr("src",im);
                                $('#btnValider').prop("disabled", true);
                                $('#nom').prop("disabled", true);
                                $('#msgErreur').text("Bien joué! Vous avez trouvé tous les animes de cette difficulté, reessayez avec une autre difficulté");
                            }
                            else{
                                // ajouter le nom de l'ancien anime a la liste animeT
                                var yolo = '<img src="{{url('images/imgAnime/')}}/'+imgRef+'" class="img-circle" id="logoA">';
                                $( "#animeT" ).append(yolo+"<p>"+nomRef+"</p>" );
                               // $('#animeT').add("nomRef");

                                imgF = data['anime'].imgAnime;
                                console.log(imgF);
                                nomF=data['anime'].nom;
                                //  prenomF=data['perso'].prenom;

                                //  console.log(data['perso'].img);
                                //$('#imgAnime').src=data['anime'].imgAnime;
                                var image = "{{url('images/imgAnime/')}}"+'/'+data['anime'].imgAnime;
                                // console.log(image);
                                $("#imgAnime").attr("src",image);
                                score=parseInt(score);
                                score =score+1;
                                //console.log(score);


                                if(score===5 && vie > 0){
                                    var targetUrl = "{{url('/quizAnimes')}}";
                                    $('#btnValider').prop("disabled", true);
                                    $('#nom').prop("disabled", true);
                                    //  $('#barreVie').attr('style',"width:0");
                                    $( "#popupwin" ).dialog({
                                        modal: true,
                                        buttons: {
                                            "Oui": function() {
                                                window.location.href=targetUrl;
                                                $( this ).dialog( "close" );
                                            },
                                            "Non": function() {

                                                $( this ).dialog( "close" );
                                            }
                                        }
                                    });
                                    //alert("GG, Partie terminée!");
                                }
                                $('#valScore').text(score);
                                $('#msgErreur').text("Bien joué! Place à l'anime suivant");
                                $("#divform").attr("class",'form-group has-success');
                                $('#nom').val("");
                            }

                        }
                        else{
                            vie=parseInt(vie);
                            $('#downVie').show('slow');
                            $('#downVie').hide(500);
                            vie =vie-1;
                            //   console.log(vie);
                            $('#valVie').text(vie);
                            $("#divform").attr("class",'form-group has-error');
                            $('#msgErreur').text("ce n'est pas le bon anime");
                            //var barre =  $('#barreVie').style;
                            //     console.log('styyyyyyyylllle');
                            //     console.log($('#barreVie').attr('style'));

                            if(vie==3){
                                $('#barreVie').attr('style',"width:75%");
                            }
                            else if(vie==2){
                                //on passe a l'orange
                                $("#barreVie").attr("class","progress-bar progress-bar-warning");
                                $('#barreVie').attr('style',"width:50%");

                            }
                            else if(vie==1){
                                //on passe au rouge
                                $("#barreVie").attr("class","progress-bar progress-bar-danger");
                                $('#barreVie').attr('style',"width:25%");
                            }
                            else if(vie==0){
                                $('#btnValider').prop("disabled", true);
                                $('#nom').prop("disabled", true);
                                $('#barreVie').attr('style',"width:0");

                                targetUrl = "{{url('/quizAnimes')}}";

                                $( "#popupconfirmation" ).dialog({
                                    modal: true,
                                    buttons: {
                                        "Oui": function() {
                                            window.location.href=targetUrl;
                                            $( this ).dialog( "close" );
                                        },
                                        "Non": function() {

                                            $( this ).dialog( "close" );
                                        }
                                    }
                                });
                            }
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