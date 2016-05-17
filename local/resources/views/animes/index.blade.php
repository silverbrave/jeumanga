@extends('defaut')

@section('css')
    <link href="{{url('style/css/stylePerso.css')}}" rel="stylesheet">
    <link href="{{url('style/css/chosen.min.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="row" style="background-color: rgba(155,155,155,0.3)">
    <div class="col-md-4">
        {!!Form::open(['method'=>'POST','route' => 'tri']) !!}
        {!!Form::text('nom', null, ['class' => 'form-control','id' =>'rechNom','placeholder'=>'Recherche par nom']) !!}
        {!! Form::close() !!}
    </div>
    <button type="button" class="btn btn-default btn-md" id="btnFiltre">
        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> de filtres
    </button>
</div>
<div class="row" id="divFiltre" style="background-color: rgba(155,155,155,0.3)">
    <div class="form-group">
        {!!Form::open(['method'=>'POST','route' => 'trigenre']) !!}
        {!!Form::label('label', 'Genre(s)') !!}
        <select data-placeholder="Choisir les genres..."  class="chosen" multiple="true" style="width:350px;" tabindex="4" id="rechGenre" name="idgenre[]">
            @foreach($genres as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        {!! Form::close() !!}
    </div>

</div>
<br>

@if (Illuminate\Support\Facades\Auth::check())
    <p><a class="btn btn-primary" href="{{ route('animes.create') }}">Ajouter un Anime <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></p>
@endif
<div id="listeAnimes">
    @foreach($animes as $anime)
        <div class="row" style="background-color: #2e6da4;color:white;">
            <div class="col-md-8">
                <h2><a href="{{url('animes/'.$anime->id)}}" class="lienAnimes">{{$anime->nom}}</a></h2>
            </div>
            @if (Illuminate\Support\Facades\Auth::check())
                <div class="col-md-2" style="padding-top:1.5% ">
                    {!! Form::open(array('route' => array('animes.destroy', $anime->id), 'method' => 'delete')) !!}
                    <button type="submit"  class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir supprimer cet anime ?');">Supprimer <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    {!! Form::close() !!}
                </div>
                <div class="col-md-2" style="padding-top:1.5% ">
                    <a class="btn btn-warning" href="{{route('animes.edit',$anime->id)}}">Modifier <span class="glyphicon glyphicon-edit"></span></a>
                </div>
            @endif

        </div>
        <div class="row">
            <div class="col-xs-6 col-md-4">
                <a href="{{url('animes/'.$anime->id)}}" class="lienAnimes"><img src="{{url('images/imgAnime/'.$anime->imgAnime)}}" alt="" class="img-thumbnail imgAnime"></a>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-7">
                <p>Année : {{$anime->annee}}</p>
                <p>Genres :
                    @foreach($anime->idgenre as $genre)
                        [{{$genre}}]
                    @endforeach
                </p>
                <p class="synopsis">Synopsis : <br>{{$anime->synopsis}}</p>
            </div>
        </div>
        <hr>

    @endforeach
</div>

@endsection


@section('script')
    <script type="text/javascript" src="{{url('style/js/jquery.auto-complete.js')}}"></script>
    <script src="{{url('style/js/chosen.jquery.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            // On cache le div a afficher :
            $(".chosen").chosen();
            $("#divFiltre").hide();
        });
        $.ajaxSetup({
            header:$('meta[name="_token"]').attr('content')
        });
        $('#btnFiltre').on('click',function(){

            $('#divFiltre').fadeToggle('fast');


        });
        $('#rechGenre').on('change',function(){
            $.ajaxSetup({
                header:$('meta[name="_token"]').attr('content')
            });
            var  valrech = $('#rechGenre').val();
            var token = $("[name=_token]").val();
            console.log(valrech);
            console.log("genres");
            var donn = {"rechGenre":valrech,"_token":token};


            $.ajax({
                type:"GET",
                url : "{!! Illuminate\Support\Facades\URL::action('AnimesController@rechGenre')!!}", // on appelle le script JSON
                dataType : 'json', // on spécifie bien que le type de données est en JSON
                data :donn,
                success : function(data){
                    $('#listeAnimes').html('');
                     console.log('toto les genres');
                    var i=0;
                    var n = data.length;
                    console.log('data:');
                    console.log(n);

                    for (i;i<n;i++){
                        var anime = data[i];
                        console.log(anime['nom']);
                        $('#listeAnimes').append(' <div class="row" style="background-color: #2e6da4;color:white;"><div class="col-md-8"><h2><a href="animes/'+anime['id']+'" class="lienAnimes">'+anime['nom']+'</a></h2></div></div><div class="row"><div class="col-xs-6 col-md-4"><a href="animes/'+anime['id']+'" class="lienAnimes"><img src="{{url('images/imgAnime/')}}'+'/'+anime['imgAnime']+'" alt="" class="img-thumbnail imgAnime"></a></div><div class="col-md-1"></div><div class="col-md-7"><p>Année : '+anime['annee']+'</p><p>Genres : '+anime['idgenre']+'</p><p class="synopsis">Synopsis : <br>'+anime['synopsis']+'</p></div></div><hr>');

                    }
                     // console.log(donnee[0]);

                    //  console.log($('#rechNom').val());

                }
            });
        });

        $('#rechNom').autoComplete({
            minChars:1,
            source : function(requete, reponse){ // les deux arguments représentent les données nécessaires au plugin
              var  valrech = $('#rechNom').val();
                var token = $("[name=_token]").val();
                console.log(valrech);
                var donn = {"rech":valrech,"_token":token};
                $.ajax({
                    type:"GET",
                    url : "{!! Illuminate\Support\Facades\URL::action('AnimesController@rechAnime')!!}", // on appelle le script JSON
                    dataType : 'json', // on spécifie bien que le type de données est en JSON
                    data :donn,
                    success : function(donnee){
                        $('#listeAnimes').html('');
                        reponse(donnee);
                       // console.log(donnee[0]);
                        console.log('toto');
                      //  console.log($('#rechNom').val());

                    }
                });

            },
            renderItem: function (item, search){
                console.log('item:');
                console.log(item);
                console.log('val liste anime');
                $('#listeAnimes').append(' <div class="row" style="background-color: #2e6da4;color:white;"><div class="col-md-8"><h2><a href="animes/'+item['id']+'" class="lienAnimes">'+item['nom']+'</a></h2></div></div><div class="row"><div class="col-xs-6 col-md-4"><a href="animes/'+item['id']+'" class="lienAnimes"><img src="{{url('images/imgAnime/')}}'+'/'+item['imgAnime']+'" alt="" class="img-thumbnail imgAnime"></a></div><div class="col-md-1"></div><div class="col-md-7"><p>Année : '+item['annee']+'</p><p>Genres : '+item['idgenre']+'</p><p class="synopsis">Synopsis : <br>'+item['synopsis']+'</p></div></div><hr>');
                var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");

               return '';
             //   return ' <div class="row" style="background-color: #2e6da4;color:white;"  data-val="'+item['nom']+'"> '+'id: '+item['id']+' '+item['nom'].replace(re, "<b>$1</b>")+'</div>';
                //return ' <div class="row" style="background-color: #2e6da4;color:white;"><div class="col-md-8"><h2><a href="#" class="lienAnimes">'+item['nom']+'</a></h2></div></div><div class="row"><div class="col-xs-6 col-md-4"><a href="#" class="lienAnimes"><img src="{{url('images/imgAnime/')}}" alt="" class="img-thumbnail imgAnime"></a></div><div class="col-md-1"></div><div class="col-md-7"><p>Année :'+item['annee']+'</p><p>Genres :'+item['idgenre']+'</p><p class="synopsis">Synopsis : <br>'+item['synopsis']+'</p></div></div><hr>';

            },
            onSelect: function(e, term, item){

                console.log('item:');
                console.log(item[0].textContent);
                var temp = item[0].textContent.split(' ');
                console.log('temp');
                console.log(temp);/*
                 //console.log($('autocomplete-suggestion.selected').data('val'));
                 var prenomUsager = document.getElementById('prenomUsager');
                 var dateNaissance = document.getElementById('dateNaissance');
                 var idUser = document.getElementById('idUser');
                 prenomUsager.value=temp[4];
                 dateNaissance.value=temp[8];
                 idUser.value=temp[2];*/
                var idAnime = temp[2];



                //alert('Item '+e.value+term.value+item.value+this.value);
            }
        });
    </script>
@endsection