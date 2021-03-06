<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('titre')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{url('style/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{url('style/css/logo-nav.css')}}" rel="stylesheet">
    <link href="{{url('style/css/footer.css')}}" rel="stylesheet">
    <link href="{{url('style/css/animate.css')}}" rel="stylesheet">

    @yield('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="http://placehold.it/150x50&text=Logo" alt="">
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-animations" data-hover="dropdown" data-animations="fadeInUp fadeInLeft fadeInUp fadeInRight">
            <ul class="nav navbar-nav">
                    <li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                @if(Illuminate\Support\Facades\Auth::check())
                    <li>
                        <a href="{{url('/logout')}}">Se deconnecter</a>
                    </li>
                @else
                    <li>
                        <a href="{{url('/login')}}">Se connecter</a>
                    </li>
                    <li>
                        <a href="{{url('/register')}}">Register</a>
                    </li>
                @endif
                <li>
                    <a href="{{url('/animes')}}">Animes</a>
                </li>
                <li class="dropdown">
                    <a  data-toggle="dropdown" class="dropdown-toggle" href="#" role="button" aria-expanded ="false" data-hover="dropdown">Quiz <b class="caret"></b></a>
                    <ul class="dropdown-menu dropdownhover-bottom" role="menu">
                        <li><a href="{{route('indexJeuAnime')}}">Animes</a></li>
                        <li><a href="{{route('indexJeuPerso')}}">Personnages</a></li>
                        <li><a href="{{url('/quizLogo')}}">Logo</a></li>
                        <li><a href="{{url('/quizObjet')}}">Objets</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->
<div class="container">
    @if(Session::has('flash_message'))
        <div class="alert alert-success">
            {{ Session::get('flash_message') }}
        </div>
    @endif
    @yield('filAriane')

    @yield('content')
    @yield('imageActivite')
</div>

<!-- /.container -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <p>
               Nb d'Animes : {{$stats['nbAnime'] or 0}}
               Nb d'épisodes : {{$stats['nbEpisode'] or 0}}
            </p>
        </div>


    </div>
</footer>
<!-- jQuery -->
<script src="{{url('style/js/jquery.js')}}"></script>
    @yield('script')
<!-- Bootstrap Core JavaScript -->
<script src="{{url('style/js/bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-hover-dropdown/2.2.1/bootstrap-hover-dropdown.min.js"></script>

</body>

</html>
