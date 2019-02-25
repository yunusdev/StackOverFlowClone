@extends('layouts.base')

@section('style')

@endsection
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
        <vue-show-question is_login = "{{auth()->check()}}" raw_question = "{{$question}}" raw_answers = "{{$question->answers}}"></vue-show-question>
        {{--@include('user.answer._index')--}}
        {{--@include('user.answer._create')--}}
    </div>
@endsection
