<?php

namespace App\Http\Controllers\User;

use App\Model\User\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        //
        $questions = Question::with('user')->latest()->paginate(6);

        return view('user.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.questions.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate(request(), [

            'title' => 'required|max:255',
            'body' => 'required'

        ]);

        $request->user()->questions()->create($request->only('title','body'));

        return redirect(route('questions.index'))->with('success', 'Question Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
        $question->increment('views');

        return view('user.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
//        if (\Gate::denies('update_question', $question)){
//
//            abort(403, 'Acesss Denied');
//
//        }
        $this->authorize('update', $question);

        return view('user.questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
        $this->validate(request(), [

            'title' => 'required|max:255',
            'body' => 'required'

        ]);

        $this->authorize('update', $question);

        $question->update($request->only('title','body'));

        return redirect(route('questions.index'))->with('success', 'Question Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //

        $this->authorize('delete', $question);

        $question->delete();

        return back()->with('danger', 'Question Deleted Successfully');
    }
}
