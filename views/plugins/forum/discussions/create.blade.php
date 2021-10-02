@extends('layouts.app')

@section('title', trans('forum::messages.discussions.title-create'))

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content forum">
                <h1 class="page-container-title">Forum</h1>
                @include('forum::elements.nav')

                <h1>{{ trans('forum::messages.discussions.title-create') }}</h1>

                <form action="{{ route('forum.forum.discussions.store', $forum->slug) }}" method="POST">
                    @include('forum::discussions._form')

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ trans('messages.actions.save') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
