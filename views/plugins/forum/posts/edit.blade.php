@extends('layouts.app')

@section('title', trans('forum::messages.posts.title-edit'))

@include('forum::elements.markdown-editor')

@section('content')
    <div class="container">
        <div class="page-container">
            <div class="page-container-content forum">
                <h1 class="page-container-title">Forum</h1>
                @include('forum::elements.nav')

                <h1>{{ trans('forum::messages.posts.title-edit') }}</h1>

                <form action="{{ route('forum.discussions.posts.update', [$post->discussion, $post]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="content">{{ trans('messages.comments.your-comment') }}</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4">{{ old('content', $post->content) }}</textarea>

                        @error('content')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
