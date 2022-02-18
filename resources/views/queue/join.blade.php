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
                        @if($turnipQueue->ask_reddit_username)
                        <div class="form-group">
                            <label for="reddit-username">
                                @lang('Reddit username')
                            </label>
                            <input type="text" name="reddit-username" id="reddit-username" class="form-control @error('reddit-username') is-invalid @enderror" maxlength="20" value="{{ old('reddit-username') }}" pattern="^[\w-]+$" />
                            @error('reddit-username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
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
                        @if(!is_null($turnipQueue->custom_question))
                        <div class="form-group">
                            <label for="custom-answer">
                                {{ $turnipQueue->custom_question }}
                            </label>
                            <input type="text" name="custom-answer" id="custom-answer" class="form-control @error('custom-answer') is-invalid @enderror" maxlength="255" value="{{ old('custom-answer') }}" />
                            @error('custom-answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
                        <div class="form-group form-text text-muted small">
                            @lang('This form is protected by reCAPTCHA and the Google
<a target="_blank" rel="noopener" href="https://policies.google.com/privacy">Privacy Policy</a> and
<a target="_blank" rel="noopener" href="https://policies.google.com/terms">Terms of Service</a> apply.')
                        </div>
                        <button type="submit"
                            class="btn btn-primary g-recaptcha"
                            data-sitekey="{{ config('recaptcha.site-key') }}"
                            data-callback='recaptchaCallback'
                            data-action='submit'>
                            @lang('Join Turnip Queue')
                        </button>
                        @error('recaptcha')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript" src="{{ mix('js/queue/join.js') }}"></script>
<script src="https://www.recaptcha.net/recaptcha/api.js"></script>
@endpush
