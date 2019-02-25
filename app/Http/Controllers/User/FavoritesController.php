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

    public function fav(Question $question, Request $request){

        if ($request->fav == 'fav'){

            return $question->favorites()->attach(auth()->id());

        }elseif ($request->fav == 'unFav'){

            return $question->favorites()->detach(auth()->id());

        }

//        return back();
    }

//    public function unFav(Question $question){
//
//        return $question->favorites()->detach(auth()->id());
//
////        return back();
//
//    }
}
