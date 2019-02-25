@extends('layouts.base')
@section('header')

    <header class="header header-inverse" style="background-color: #c2b2cd;">
        <div class="container text-center">

            <div class="row" style="margin-top: -40px">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h3>{{$question->title}}</h3>

                </div>
            </div>

        </div>
    </header>
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h3>{{$question->title}}</h3></small>
                                <div class="ml-auto">
                                    <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Go back to all Questions</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a title="Useful Question" class="vote-up {{auth()->guest() ? 'off' : ($question->is_up_voted ? 'vote-accepted' : '')}}"
                                   onclick="event.preventDefault(); document.getElementById('upVote-{{$question->id}}').submit();">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">{{$question->votes_count}}</span>
                                <a title="Not Useful Question" class="vote-down {{auth()->guest() ? 'off' : ($question->is_down_voted ? 'vote-accepted' : '')}}"
                                   onclick="event.preventDefault(); document.getElementById('downVote-{{$question->id}}').submit();">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form action="{{route('upVote.question', $question->id)}}" id="upVote-{{$question->id}}" style="display: none" method="post">
                                    @csrf
                                </form>
                                <form action="{{route('downVote.question', $question->id)}}" id="downVote-{{$question->id}}" style="display: none" method="post">
                                    @csrf
                                </form>
                                <a title="Favorite Que!"
                                   onclick="event.preventDefault(); document.getElementById('favorites-{{$question->id}}').submit()"
                                   class="favorite mt-2 {{auth()->guest() ? 'off' : ($question->is_favorited ? 'favorited' : '')}}">
                                    <i class="fas fa-star fa-2x"></i>
                                    <span class="favorites-count">{{$question->favorites_counts}}</span>
                                </a>

                                <form id="favorites-{{$question->id}}" action="/user/{{$question->id}}/favorite" style="display: none" method="post">
                                    @csrf
                                    @if($question->is_favorited)
                                        @method('delete')
                                    @endif
                                </form>

                            </div>
                            <div class="media-body">
                                {!! $question->body_html !!}
                                <div class="float-right">
                                    <span class="text-muted">Answered {{$question->created_date}}</span>
                                    <div class="media mt-2">
                                        <a href="{{$question->user->url}}" class="pr-2">
                                            <img src="{{$question->user->avatar}}" alt="" >
                                        </a>
                                        <div class="media-body">
                                            <a href="{{$question->user->url}}">{{$question->user->name}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('user.answer._index')
        @include('user.answer._create')
    </div>
@endsection
