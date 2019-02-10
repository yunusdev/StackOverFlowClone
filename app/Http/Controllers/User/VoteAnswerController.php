<?php

namespace App\Http\Controllers\User;

use App\Model\User\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoteAnswerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upVoteAnswer(Answer $answer){

        if ($answer->isUpVoted()){

            $answer->votes()->detach(auth()->id(), ['vote' => 1]);

        }
        elseif ($answer->isDownVoted()){

            $answer->votes()->updateExistingPivot(auth()->id(), ['vote' => 1]);
        }
        else{

            $answer->votes()->attach(auth()->id(), ['vote' => 1]);

        }

        $vote_count = $answer->votes()->withPivot('vote')->pluck('vote')->sum();

        $answer->votes_count = $vote_count;
        $answer->save();

        return back();

    }

    public  function downVoteAnswer(Answer $answer){

        if ($answer->isUpVoted()){

            $answer->votes()->updateExistingPivot(auth()->id(), ['vote' => -1]);

        }
        elseif ($answer->isDownVoted()){

            $answer->votes()->detach(auth()->id(), ['vote' => -1]);

        }
        else{

            $answer->votes()->attach(auth()->id(), ['vote' => -1]);

        }

        $vote_count = $answer->votes()->withPivot('vote')->pluck('vote')->sum();

        $answer->votes_count = $vote_count;
        $answer->save();

        return back();

    }
}
