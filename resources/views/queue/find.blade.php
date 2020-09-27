@extends('layouts.app')

@section('title', __('Find Queue - Turnip Queue'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Find Turnip Queue')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{ route('queue.find-post') }}">
                        @csrf
                        <div class="form-group">
                            <label for="queue-id">
                                @lang('Enter a Turnip Queue Token to join the Queue:')
                            </label>
                            <input type="text" name="token" id="queue-id" class="form-control @error('token') is-invalid @enderror" />
                            @error('token')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            @lang('Join Turnip Queue')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
