@extends('layouts.app')

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content error">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body text-center">
                                <h1>@yield('code')</h1>
                                <h2>@yield('title')</h2>
                                <p>@yield('message')</p>

                                <a style="margin-top: 20px" href="{{ route('home') }}" class="btn btn-primary">{{ trans('errors.home') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
