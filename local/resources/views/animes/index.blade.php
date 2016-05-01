@extends('defaut')
@section('content')
<h1>Les animes</h1>
@if (Illuminate\Support\Facades\Auth::check())
    <p><a class="btn btn-primary" href="{{ route('animes.create') }}">Ajouter un Anime</a></p>
@endif
@endsection
