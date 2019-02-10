@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Create Questions</h2>
                            <div class="ml-auto">
                                <a href="{{route('questions.index')}}" class="btn btn-outline-secondary">Go back to all Questions</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="{{route('questions.store')}}">
                            @include('layouts._form',  ['buttonText' => 'Create Question'])
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
