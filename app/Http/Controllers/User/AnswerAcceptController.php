<?php

namespace App\Http\Controllers\User;

use App\Model\User\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerAcceptController extends Controller
{
    //
    public  function  __invoke(Answer $answer)
    {
        $this->authorize('accept', $answer);

         $answer->question->acceptBestAnswer($answer);

         return $answer->fresh();

//        return back();
    }
}
