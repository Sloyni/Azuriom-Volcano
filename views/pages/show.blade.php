@extends('layouts.app')

@section('title', $page->title)
@section('description', $page->description)

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="page-container-title">{{ $page->title }}</h1>

                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
