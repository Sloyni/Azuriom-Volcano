@extends('layouts.app')

@section('title', trans('auth.passwords.confirm'))

@section('content')
    <div class="container">
        <div class="page-container">
            <div class="page-container-content user">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="page-container-title">{{ trans('auth.passwords.confirm') }}</div>

                            <div class="card-body">
                                {{ trans('auth.need-confirm') }}

                                <form method="POST" action="{{ route('password.confirm') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('auth.password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ trans('auth.passwords.confirm') }}
                                            </button>

                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ trans('auth.forgot-password') }}
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection