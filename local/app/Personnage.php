<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnage extends Model
{
    protected $fillable = ['id','idAnime','nom','prenom','desc','img','role'];
}
