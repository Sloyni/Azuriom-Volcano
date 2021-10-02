@extends('layouts.app')

@section('title', trans('paysafecardmanual::messages.title'))

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content">
                <div class="card shadow mb-4">
                    <h5 class="card-header">
                        {{ trans('paysafecardmanual::messages.title') }}
                    </h5>

                    <div class="card-body center">
                        <form action="{{ route('paysafecardmanual.pay') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="code">{{ trans('paysafecardmanual::messages.fields.pin') }}</label>
                                <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>

                                @error('code')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ trans('messages.actions.send') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
