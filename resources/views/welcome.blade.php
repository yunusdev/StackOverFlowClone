@extends('layouts.base')
@section('header')
    <header class="header header-inverse bg-fixed" style="background-image: url({{asset('assets/img/bg-stars.jpg')}})" data-overlay="8">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h1>Question and Answer Forum</h1>
                    <p class="fs-18 opacity-70">A clone of stackoverflow. Question and Answer</p>

                </div>
            </div>

        </div>
    </header>
    <!-- END Header -->

@endsection

@section('content')
    <div class="container mb-50" >
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="javascript;" data-target="#createQuestion" data-toggle="modal" class="btn btn-outline-info">Ask Question</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts._message')
                        @forelse($questions as $question)
                            <div class="media">
                                <div class="flex flex-column counters">
                                    <div class="vote">
                                        <strong>{{$question->votes_count}}</strong> {{str_plural('vote', $question->votes_count)}}
                                    </div>
                                    <div class=" status {{$question->status}}">
                                        <strong>{{$question->answers_count}}</strong> {{str_plural('answer', $question->answers_count)}}
                                    </div>
                                    <div class="view">
                                        {{$question->views . ' ' . str_plural('view', $question->views)}}
                                    </div>

                                </div>
                                <div class="media-body">
                                    <div class="d-flex align-items-center">
                                        <h3 class="mt-0"><a href="{{$question->url}}">{{$question->title}}</a></h3>
                                        <div class="ml-auto">
                                            @can('update',  $question)
                                                <a href="{{route('questions.edit', $question->id)}}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan
                                            @can('delete',  $question)
                                                <form class="form-delete" action="{{route('questions.destroy', $question->id)}}" method="post">
                                                    @csrf
                                                    {{method_field('delete')}}
                                                    <button onclick="return confirm('Are you sure')" class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <p class="lead">
                                        Asked by <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        <small class="text-muted">{{$question->created_date}}</small>
                                    </p>
                                    <div>
                                        {{$question->excerpt}}
                                    </div>

                                </div>

                            </div>
                            <hr>
                        @empty

                            <div class="alert alert-warning">
                                There are no questions. Go <a href="{{route('questions.create')}}">Here</a> to create a question...
                            </div>

                        @endforelse

                        {{$questions->links()}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
