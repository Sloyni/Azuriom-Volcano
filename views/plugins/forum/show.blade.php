@extends('layouts.app')

@section('title', $forum->name)

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content forum">
                <h1 class="page-container-title">Forum</h1>
                @include('forum::elements.nav')

                <h1 class="h2">{{ $forum->name }}</h1>

                @if(! $forum->forums->isEmpty())
                    <div class="card mb-4">
                        <div class="list-group list-group-flush">
                            @foreach($forum->forums as $subForum)
                                <div class="list-group-item">
                                    <div class="row">
                                        <div class="col-xl-1 col-md-2 col-2 text-center">
                                            <i class="{{ $subForum->icon ?? 'fas fa-comments' }} fa-2x fa-fw forum-big-icon"></i>
                                        </div>

                                        <div class="col-xl-8 col-md-7 col-10 pl-md-0">
                                            <h3 class="h5">
                                                <a href="{{ route('forum.show', $subForum->slug) }}">{{ $subForum->name }}</a>
                                            </h3>

                                            {{ $subForum->description ?? ''}}
                                        </div>

                                        <div class="col-xl-3 col-md-3 d-none d-md-block">
                                            {{ trans_choice('forum::messages.forums.discussions-count', $subForum->discussions_count) }}
                                            <br>
                                            {{ trans_choice('forum::messages.discussions.posts-count', $subForum->posts_count) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="card mb-3">
                    <div class="card-header">{{ trans('forum::messages.discussions.title') }}</div>
                    <div class="list-group list-group-flush">
                        @foreach($forum->discussions as $discussion)
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-2 col-md-1 text-center">
                                        <i class="fas fa-comment-dots fa-2x fa-fw forum-big-icon"></i>
                                    </div>

                                    <div class="col-8 col-md-5 pl-md-0">
                                        <a href="{{ route('forum.discussions.show', $discussion) }}">
                                            @foreach($discussion->tags as $tag)
                                                <span class="badge" style="{{ $tag->getBadgeStyle() }}">{{ $tag->name }}</span>
                                            @endforeach
                                            {{ $discussion->title }}
                                        </a>
                                        <br>
                                        <small>{{ $discussion->author->name }}, {{ format_date($discussion->created_at) }}</small>
                                    </div>

                                    <div class="col-2">
                                        @if($discussion->is_pinned || $discussion->is_locked)
                                            <div class="float-md-right">
                                                @if($discussion->is_pinned)
                                                    <i class="fas fa-thumbtack fa-fw text-primary" title="{{ trans('forum::messages.discussions.pinned') }}" data-toggle="tooltip"></i>
                                                @endif

                                                @if($discussion->is_locked)
                                                    <i class="fas fa-lock fa-fw text-warning" title="{{ trans('forum::messages.discussions.locked') }}" data-toggle="tooltip"></i>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-2 d-none d-md-block">
                                        {{ trans_choice('forum::messages.discussions.posts-count', $discussion->posts_count) }}
                                    </div>

                                    <div class="col-md-2 d-none d-md-block">
                                        @if(! $discussion->posts->isEmpty())
                                            {{ $discussion->posts->first()->author->name }},
                                            <small>{{ format_date($discussion->posts->first()->created_at) }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{ $forum->discussions->links() }}

                @if($forum->is_locked)
                    <div class="alert alert-warning" role="alert">
                        <i class="fas fa-lock"></i> {{ trans('forum::messages.forums.locked') }}
                    </div>
                @endif

                @if(! $forum->is_locked || optional(auth()->user())->isAdmin())
                    @can('create', \Azuriom\Plugin\Forum\Models\Discussion::class)
                        <a href="{{ route('forum.forum.discussions.create', $forum->slug) }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            {{ trans('messages.actions.create') }}
                        </a>
                    @endcan
                @endif
            </div>
        </div>
    </div>
@endsection
