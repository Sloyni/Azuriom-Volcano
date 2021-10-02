@extends('layouts.app')

@section('title', $discussion->title)

@push('meta')
    <meta property="og:article:author:username" content="{{ $discussion->author->name }}">
    <meta property="og:article:published_time" content="{{ $discussion->created_at->toIso8601String() }}">
    <meta property="og:article:modified_time" content="{{ $discussion->updated_at->toIso8601String() }}">
@endpush

@include('forum::elements.markdown-editor', ['editorMinHeight' => 150])

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content forum">
                <h1 class="page-container-title">Forum</h1>
                @include('forum::elements.nav')

                <div class="row mb-2">
                    <div class="col-md-9">
                        <h1>
                            @foreach($discussion->tags as $tag)
                                <small>
                                    <span class="badge" style="{{ $tag->getBadgeStyle() }}">{{ $tag->name }}</span>
                                </small>
                            @endforeach
                            {{ $discussion->title }}
                        </h1>
                    </div>

                    <div class="col-md-3 d-flex align-items-center justify-content-md-end">
                        <div>
                            @can('forum.discussions')
                                <form action="{{ route('forum.discussions.'.($discussion->is_pinned ? 'unpin' : 'pin'), $discussion) }}" method="POST" class="d-inline-block">
                                    @csrf

                                    <button class="btn btn-success btn-sm @if($discussion->is_pinned) active @endif" title="{{ trans('forum::messages.actions.'.($discussion->is_pinned ? 'unpin' : 'pin')) }}" data-toggle="tooltip">
                                        <i class="fas fa-thumbtack fa-fw"></i>
                                    </button>
                                </form>

                                <form action="{{ route('forum.discussions.'.($discussion->is_locked ? 'unlock' : 'lock'), $discussion) }}" method="POST" class="d-inline-block">
                                    @csrf

                                    <button class="btn btn-secondary btn-sm @if($discussion->is_locked) active @endif" title="{{ trans('forum::messages.actions.'.($discussion->is_locked ? 'unlock' : 'lock')) }}" data-toggle="tooltip">
                                        <i class="fas fa-lock{{ $discussion->is_locked ? '-open' : ''}} fa-fw"></i>
                                    </button>
                                </form>
                            @endcan

                            @if(! $discussion->is_locked || optional(auth()->user())->isAdmin())
                                @can('update', $discussion)
                                    <a href="{{ route('forum.discussions.edit', $discussion) }}" class="btn btn-info btn-sm" title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                @endcan

                                @can('delete', $discussion)
                                    <form action="{{ route('forum.discussions.destroy', $discussion) }}" method="POST" class="d-inline-block" onsubmit="return confirm('{{ trans('forum::messages.discussions.delete') }}')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm" title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip">
                                            <i class="fas fa-trash fa-fw"></i>
                                        </button>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>

                @foreach($discussion->posts as $post)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-2 col-md-3 text-center">
                                    <div class="row">
                                        <div class="col-3 col-md-12">
                                            <img src="{{ game()->getAvatarUrl($post->author, 128) }}" alt="{{ $post->author->name }}" class="img-fluid mb-3 rounded-lg" style="max-width: 80px">
                                        </div>

                                        <div class="col-9 col-md-12">
                                            <h5>{{ $post->author->name }}</h5>

                                            <span class="badge badge-label" style="{{ $post->author->role->getBadgeStyle() }};">{{ $post->author->role->name }}</span>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="d-none d-md-block">
                                        <ul class="list-unstyled">
                                            <li>
                                                <strong>{{ trans('forum::messages.profile.discussions') }}:</strong> {{ $post->author->discussions_count }}
                                            </li>
                                            <li>
                                                <strong>{{ trans('forum::messages.profile.posts') }}:</strong> {{ $post->author->posts_count }}
                                            </li>
                                            <li>
                                                <strong>{{ trans('forum::messages.profile.likes') }}:</strong> {{ $post->author->likes_count }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xl-10 col-md-9">
                                    <div class="mb-3">
                                        <small>{{ format_date($post->created_at, true) }}</small>
                                    </div>

                                    <div class="markdown-body mb-3">
                                        {{ $post->parseContent() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-primary btn-sm @if($post->isLiked()) active @endif" @guest disabled @endguest data-like-url="{{ route('forum.posts.like', $post) }}">
                                <i class="fas fa-thumbs-up"></i>
                                <span class="likes-count">{{ $post->likes->count() }}</span>
                                <span class="d-none spinner-border spinner-border-sm load-spinner" role="status"></span>
                            </button>

                            @if(! $loop->first && (! $discussion->is_locked || optional(auth()->user())->isAdmin()))
                                @can('edit', $post)
                                    <a href="{{ route('forum.discussions.posts.edit', [$discussion, $post]) }}" class="btn btn-info btn-sm" title="{{ trans('messages.actions.edit') }}" data-toggle="tooltip">
                                        <i class="fas fa-edit fa-fw"></i>
                                    </a>
                                @endcan

                                @can('delete', $post)
                                    <form action="{{ route('forum.discussions.posts.destroy', [$discussion, $post]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('{{ trans('forum::messages.posts.delete') }}')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm" title="{{ trans('messages.actions.delete') }}" data-toggle="tooltip">
                                            <i class="fas fa-trash fa-fw"></i>
                                        </button>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </div>
                @endforeach

                {{ $discussion->posts->links() }}

                @if($discussion->is_locked)
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-lock"></i> {{ trans('forum::messages.discussions.info-locked') }}
                    </div>
                @endif

                @if(! $discussion->is_locked || optional(auth()->user())->isAdmin())
                    @can('create', \Azuriom\Plugin\Forum\Models\Post::class)
                        <div class="card shadow-sm mb-3">
                            <div class="card-header">
                                <span class="h5">{{ trans('forum::messages.discussions.respond') }}</span>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('forum.discussions.posts.store', $discussion) }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="content">{{ trans('messages.fields.content') }}</label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4"></textarea>

                                        @error('content')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-reply"></i> {{ trans('forum::messages.discussions.respond') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endcan
                @endif
            </div>
        </div>
    </div>
@endsection
