@extends('layouts.app')

@section('title', $ticket->subject)

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content support-ticket-show">
                <h1 class="page-container-title">{{ $ticket->subject }}</h1>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                         <span class="badge badge-{{ $ticket->isClosed() ? 'danger' : 'success' }}">
                             {{ $ticket->statusMessage() }}
                         </span>
                         @lang('support::messages.tickets.status-info', ['author' => $ticket->author->name, 'category' => $ticket->category->name, 'date' => format_date($ticket->created_at)])
                    </div>
                </div>

                @foreach($ticket->comments as $comment)
                    <div class="card shadow-sm mb-3">
                        <div class="card-header @if($ticket->author->is($comment->author)) text-info @else text-primary @endif">
                            @lang('messages.comments.author', ['user' => $comment->author->name, 'date' => format_date($comment->created_at, true)])
                        </div>
                        <div class="card-body media">
                            <img class="d-flex mr-3 rounded" src="{{ $comment->author->getAvatar() }}" alt="{{ $comment->author->name }}" height="55">
                            <div class="media-body">
                                <div class="content-body">
                                    {{ $comment->parseContent() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        @if($ticket->isClosed())
                            <p class="text-danger">{{ trans('support::messages.tickets.closed') }}</p>
                        @else
                            <form action="{{ route('support.tickets.comments.store', $ticket) }}" method="POST" class="mb-2">
                                @csrf

                                <div class="form-group">
                                    <label for="content">{{ trans('messages.comments.your-comment') }}</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                                </div>

                                @error('content')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror

                                <button type="submit" class="btn btn-primary">
                                    {{ trans('messages.actions.comment') }}
                                </button>
                            </form>

                            <form action="{{ route('support.tickets.close', $ticket) }}" method="POST">
                                @csrf

                                <button type="submit" class="btn btn-danger">
                                    {{ trans('support::messages.actions.close') }}
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
