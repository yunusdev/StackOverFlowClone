@extends('layouts.app')

<div class="modal fade" id="createQuestion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="card card-shadowed p-50 w-400 mb-0" style="max-width: 100%">
            <h5 class="text-uppercase text-center">Create Question</h5>
            <hr>
            <div class="modal-body">
                <div class="form-group">
                    <label for="question-title">Question Title</label>
                    <input type="text" name="title" v-model="question.title"  id="question-title" class="form-control">

                </div>
                <div class="form-group">
                    <label for="question-body">Explain you question</label>
                    <textarea name="body" id="question-body" v-model="question.body" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-bold btn-block btn-primary" type="button">Create Question</button>
                </div>

            </div>
        </div>
    </div>
</div>
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
                            @csrf
                            <div class="form-group">
                                <label for="question-title">Question Title</label>
                                <input type="text" name="title" value="{{ old('title') }}" id="question-title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">

                                @if ($errors->has('title'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="question-body">Explain you question</label>
                                <textarea name="body" id="question-body" rows="10" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}">{{ old('body')}}</textarea>
                                @if ($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary btn-lg">Create Question</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
