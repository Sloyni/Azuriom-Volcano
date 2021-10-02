@extends('layouts.app')

@section('title', trans('forum::messages.discussions.title-edit'))

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content forum">
                <h1 class="page-container-title">Forum</h1>
                @include('forum::elements.nav')

                <h1>{{ trans('forum::messages.discussions.title-edit') }}</h1>

                <form action="{{ route('forum.discussions.update', $discussion) }}" method="POST">
                    @method('PUT')

                    @include('forum::discussions._form')

                    @can('forum.discussions')
                        <div class="form-group">
                            <label for="forumSelect">{{ trans('forum::messages.fields.forum') }}</label>

                            <select class="custom-select" id="forumSelect" name="forum_id">
                                @foreach($forums as $forum)
                                    <option value="{{ $forum->id }}" @if($forum->id === old('forum_id', $discussion->forum_id)) selected @endif>{{ $forum->name }}</option>
                                @endforeach
                            </select>

                            @error('forum_id')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    @endcan

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        {{ trans('messages.actions.save') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
