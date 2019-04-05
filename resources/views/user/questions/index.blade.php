@extends('layouts.base')
@section('header')
    <header class="header header-inverse bg-fixed" style="background-image: url({{asset('assets/img/bg-stars.jpg')}})" data-overlay="8">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h1>Questions and Answers Forum</h1>
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
                <vue-questions is_login="{{auth()->check()}}" raw_questions="{{$questions}}"></vue-questions>
            </div>
        </div>
    </div>
@endsection
