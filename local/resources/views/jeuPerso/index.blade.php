@extends('defaut')
@section('css')
    <link href="{{url('style/css/jeuPerso.css')}}" rel="stylesheet">
@endsection
@section('content')
    <h1>JEU SUR LES PERSONNAGES</h1>
        <div class="col-md-2"></div>
        <div class="col-md-5" id="jeu">
            <h3>Entrez le nom ou le prénom du personnage</h3>
            <img src="{{url('images/persos/'.$perso['img'])}}" alt="" class="img-responsive" id="imgAnime">
            <div class="form-group" id="divform">

                {!!Form::open(['route'=>'verif','method'=>'POST','id'=>'formPerso']) !!}
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
            <h4>Vies:</h4><p id="valVie">5</p>

        </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var nomF= "{{$perso['nom']}}";
            var prenomF= "{{$perso['prenom']}}";
            $('#formPerso').on('submit',function(e){

                var score = $('#valScore').text();
                var vie = $('#valVie').text();
//le probleme est ici vu qu'on utilise les var pghp
                var nomPersoRentre = $('#nom').val();
                nomPersoRentre = nomPersoRentre.toLowerCase();
                console.log('nom du perso rentre : '+nomPersoRentre);

                var nomRef = nomF;
                nomRef = nomRef.toLowerCase();
                console.log('nom du peros ref : '+nomRef);

                 var prenomRef = prenomF;
                prenomRef= prenomRef.toLowerCase();
                console.log('prenom du peros ref : '+prenomRef);

                var anime = "{{$anime['nom']}}";
                var token = $("[name=_token]").val();
                console.log(token);
                $.ajaxSetup({
                    header:$('meta[name="_token"]').attr('content')
                });


                    //var data = $(this).serialize();
                    var data = {
                        "nom":nomPersoRentre,
                        "prenomPerso":prenomRef,
                        "nomRef":nomRef,
                        "anime":anime,
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
                                var perso = data['perso'];

                                nomF=data['perso'].nom;
                                prenomF=data['perso'].prenom;

                                console.log(data['perso'].img);
                               //$('#imgAnime').src=data['anime'].imgAnime;
                                var image = "{{url('images/persos/')}}"+'/'+data['perso'].img;
                                console.log(image);
                                $("#imgAnime").attr("src",image);
                                score=parseInt(score);
                                score =score+1;
                                console.log(score);


                                if(score===5 && vie > 0){
                                    alert("GG, Partie terminée!");
                                }
                                $('#valScore').text(score);
                                $('#msgErreur').text("Bien joué! Place au personnage suivant");
                                $("#divform").attr("class",'form-group has-success');
                                $('#nom').val("");
                            }
                            else{
                                vie=parseInt(vie);
                                vie =vie-1;
                                console.log(vie);
                                $('#valVie').text(vie);
                                $("#divform").attr("class",'form-group has-error');
                                $('#msgErreur').text("ce n'est pas le bon personnage");
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