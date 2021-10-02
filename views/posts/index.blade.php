@extends('layouts.app')

@section('title', trans('messages.posts.posts'))

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content">
                <div class="posts">
                    @foreach($posts as $post)
                        <div class="post">
                            @if($post->hasImage())
                                <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}">
                            @endif
                            <div class="post-body">
                                <h3 class="post-title"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                                <p class="post-text">{{ Str::limit(strip_tags($post->content), 250) }}</p>
                                <a class="post-link" href="{{ route('posts.show', $post) }}">{{ trans('messages.posts.read') }}</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
