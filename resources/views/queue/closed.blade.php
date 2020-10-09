@extends('layouts.app')

@section('title', __('Join Queue - Turnip Queue'))

@push('meta')
<meta name="robots" content="noindex">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Queue Closed')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        @lang('Unfortunately, this queue has been closed.')
                    </p>

                    <p>
                        @lang('If you believe this to be in error, try again or contact the person who sent you this link.')
                    </p>
                    
                    <p>
                        <a class="btn btn-primary" href="{{ route('index') }}">
                            @lang('Go to home page')
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection