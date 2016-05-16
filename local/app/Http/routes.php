<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/',['as'=>'accueil','uses'=>'AnimesController@accueil']);

Route::auth();
Route::get('animes/rech',['uses'=>'AnimesController@rechAnime','as'=>'tri']);
Route::resource('animes','AnimesController');
Route::resource('genres','GenresController');
Route::resource('news','NewsController');
Route::resource('personnages','PersosController');
Route::get('quizPersos',['uses'=>'JeuController@index','as'=>'indexJeuPerso']);
Route::get('quizAnimes',['uses'=>'JeuAnimesController@index','as'=>'indexJeuAnime']);
Route::post('quizAnimes/',['as'=>'verifAnime','uses'=>'JeuAnimesController@verifAnime']);
Route::post('quizPersos/',['as'=>'verif','uses'=>'JeuController@verifNom']);
Route::get('quizLogo',['uses'=>'JeuLogoController@index','as'=>'indexJeuLogo']);
Route::post('quizLogo/',['as'=>'verifLogo','uses'=>'JeuLogoController@verifNomLogo']);


