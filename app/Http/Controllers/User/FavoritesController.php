<?php

namespace App\Http\Controllers\User;

use App\Model\User\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoritesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fav(Question $question){

        $question->favorites()->attach(auth()->id());

        return back();
    }

    public function unFav(Question $question){

        $question->favorites()->detach(auth()->id());

        return back();

    }
}
