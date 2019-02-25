<?php

namespace App\Http\Controllers\User;

use App\Model\User\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoteQuestionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upVoteQuestion(Question $question){

        if ($question->isUpVoted()){

            $question->votes()->detach(auth()->id(), ['vote' => 1]);

        }
        elseif ($question->isDownVoted()){

            $question->votes()->updateExistingPivot(auth()->id(), ['vote' => 1]);
        }
        else{

            $question->votes()->attach(auth()->id(), ['vote' => 1]);

        }

        $vote_count = $question->votes()->withPivot('vote')->pluck('vote')->sum();

        $question->votes_count = $vote_count;
        $question->save();

//        return request()->json('ok');
        return $question->fresh();


    }

    public  function downVoteQuestion(Question $question){

        if ($question->isUpVoted()){

            $question->votes()->updateExistingPivot(auth()->id(), ['vote' => -1]);

        }
        elseif ($question->isDownVoted()){

            $question->votes()->detach(auth()->id(), ['vote' => -1]);

        }
        else{

            $question->votes()->attach(auth()->id(), ['vote' => -1]);

        }

        $vote_count = $question->votes()->withPivot('vote')->pluck('vote')->sum();

        $question->votes_count = $vote_count;
        $question->save();

        return $question->fresh();

//        return request()->json('ok');
//        return back();

    }
}
