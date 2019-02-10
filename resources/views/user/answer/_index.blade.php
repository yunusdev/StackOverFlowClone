@if($question->answers_count > 0)
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{$question->answers_count. ' ' . str_plural('Answer', $question->answers_count) }}</h2>
                    </div>
                    <hr>
                    @include('layouts._message')
                    @foreach($question->answers as $answer)
                        <div class="media">
                            <div class="d-flex flex-column vote-controls">
                                <a title="Useful Question" class="vote-up {{auth()->guest() ? 'off' : ($answer->is_up_voted ? 'vote-accepted' : '')}}"
                                   onclick="event.preventDefault(); document.getElementById('upVote-answer-{{$answer->id}}').submit();">
                                    <i class="fas fa-caret-up fa-3x"></i>
                                </a>
                                <span class="votes-count">{{$answer->votes_count}}</span>
                                <a title="Not Useful Question" class="vote-down {{auth()->guest() ? 'off' : ($answer->is_down_voted ? 'vote-accepted' : '')}}"
                                   onclick="event.preventDefault(); document.getElementById('downVote-answer-{{$answer->id}}').submit();">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                </a>
                                <form action="{{route('upVote.answer', $answer->id)}}" id="upVote-answer-{{$answer->id}}" style="display: none" method="post">
                                    @csrf
                                </form>
                                <form action="{{route('downVote.answer', $answer->id)}}" id="downVote-answer-{{$answer->id}}" style="display: none" method="post">
                                    @csrf
                                </form>
                                @can('accept', $answer)
                                    <a title="Best Que!"
                                       class="{{$answer->status_best}} mt-2 "
                                       onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();">
                                        <i class="fas fa-check fa-2x"></i>
                                    </a>
                                @else
                                    @if($answer->is_best)
                                        <a title="Best Que!" class="{{$answer->status_best}} mt-2 ">
                                            <i class="fas fa-check fa-2x"></i>
                                        </a>
                                    @endif
                                @endcan

                                <form action="{{route('accept.answer', $answer->id)}}" id="accept-answer-{{$answer->id}}" method="post" style="display: none">@csrf</form>
                            </div>
                            <div class="media-body">
                                {!! $answer->body_html !!}

                                <div class="row">
                                    <div class="col-4">
                                        <div class="ml-auto">
                                            @can ('update', $answer)
                                                <a href="{{route('questions.answers.edit', [$question->id, $answer->id])}}" class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan
                                            @can ('delete', $answer)
                                                <form action="{{route('questions.answers.destroy', [$question->id, $answer->id])}}" method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>

                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="col-4">
                                        <span class="text-muted">Answered {{$answer->created_date}}</span>
                                        <div class="media mt-2">
                                            <a href="{{$answer->user->url}}" class="pr-2">
                                                <img src="{{$answer->user->avatar}}" alt="" >
                                            </a>
                                            <div class="media-body">
                                                <a href="{{$answer->user->url}}">{{$answer->user->name}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endif