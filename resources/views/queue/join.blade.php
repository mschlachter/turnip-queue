@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Join Turnip Queue')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form id="form-seeker-details" method="post" action="{{ route('queue.register', compact('turnipQueue')) }}">
                        @csrf
                        <p>
                            @lang('All fields are required.')
                        </p>
                        <div class="form-group">
                            <label for="reddit-username">
                                @lang('Reddit username')
                            </label>
                            <input type="text" name="reddit-username" id="reddit-username" class="form-control @error('reddit-username') is-invalid @enderror" maxlength="20" value="{{ old('reddit-username') }}" pattern="^[\w-]+$" />
                            @error('reddit-username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="in-game-username">
                                @lang('In-game username')
                            </label>
                            <input type="text" name="in-game-username" id="in-game-username" class="form-control @error('in-game-username') is-invalid @enderror" maxlength="20" value="{{ old('in-game-username') }}" />
                            @error('in-game-username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="island-name">
                                @lang('Island name')
                            </label>
                            <input type="text" name="island-name" id="island-name" class="form-control @error('island-name') is-invalid @enderror" maxlength="10" value="{{ old('island-name') }}" />
                            @error('island-name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="custom-answer">
                                {{ $turnipQueue->custom_question }}
                            </label>
                            <input type="text" name="custom-answer" id="custom-answer" class="form-control @error('custom-answer') is-invalid @enderror" maxlength="255" value="{{ old('custom-answer') }}" />
                            @error('custom-answer')
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