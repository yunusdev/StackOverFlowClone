<?php

namespace App\Http\Controllers\User;

use App\Model\User\Answer;
use App\Model\User\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnswerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        //
        $this->validate(request(), [

            'body' => 'required'
        ]);

        $ans =$question->answers()->create([
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);

        return Answer::where('id', $ans->id)->first();

//        return back()->with('success', 'Answer Created Successfully');


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        //
        $this->authorize('update', $answer);

        return view('user.answer.edit', compact('answer', 'question'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        //
        $this->authorize('update', $answer);

        $this->validate(request(), [

            'body' => 'required'
        ]);


        $answer->update($request->only('body'));

        return $answer->fresh();

//        return redirect(route('questions.show', $question->slug))->with('success','Answer Edited Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        //
        $this->authorize('delete', $answer);

        $answer->delete();

        return request()->json('ok');
    }
}
