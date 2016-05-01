<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $fillable=['id','nom','nb_ep','synopsis','imgAnime','logo','op','idgenre','annee','statut'];
}
