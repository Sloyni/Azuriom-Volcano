@extends('layouts.app')

@section('title', 'Payment')

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content">
                <h1>{{ trans('shop::messages.payment.success') }}</h1>

                <p>{{ trans('shop::messages.payment.success-info') }}</p>
            </div>
        </div>
    </div>
@endsection
