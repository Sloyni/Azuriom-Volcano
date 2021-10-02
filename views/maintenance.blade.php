@extends('layouts.app')

@section('title', trans('messages.maintenance'))

@section('content')
    <div class="container content">
        <div class="page-container">
            <div class="page-container-content error">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <h1 class="page-container-title">{{ trans('messages.maintenance') }}</h1>

                            <div class="card-body">
                                {!! $maintenanceMessage !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
