@extends('layouts.app')

@section('title', __('Create Queue - Turnip Queue'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Create Turnip Queue')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($openQueue = Auth::user()->turnipQueues()->open()->first())
                        <div class="alert alert-danger" role="alert">
                            <p>
                                @lang('You currently have an open queue:')
                                <a href="{{ route('queue.admin', ['turnipQueue' => $openQueue]) }}">
                                    @lang('view your open queue')
                                </a>
                            </p>
                            <p class="mb-0">
                                @lang('Opening a new queue will close your currently opened queue.')
                            </p>
                        </div>
                    @endif

                    <form id="form-queue-details" method="post" action="{{ route('queue.store') }}">
                        @csrf
                        <p>
                            @lang('All fields are required.')
                        </p>
                        <div class="form-group">
                            <label for="dodo-code">
                                @lang('Dodo Code')
                            </label>
                            <input type="text" name="dodo-code" id="dodo-code" class="form-control @error('dodo-code') is-invalid @enderror" maxlength="8" placeholder="XXXXX" value="{{ old('dodo-code') }}" />
                            @error('dodo-code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="duration">
                                @lang('Time to keep Queue open (hours)')
                            </label>
                            <input type="range" class="custom-range @error('duration') is-invalid @enderror" min="1" max="5" step="1" id="duration" name="duration" value="{{ old('duration') ?? 3 }}" aria-describedby="duration-help-text" >
                            <p id="duration-help-text" class="form-text text-muted">
                                <span id="duration-display">3</span>
                                @lang('hours')
                            </p>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="visitors">
                                @lang('Visitors to allow at a time')
                            </label>
                            <input type="range" class="custom-range @error('visitors') is-invalid @enderror" min="1" max="10" step="1" id="visitors" name="visitors" value="{{ old('visitors') ?? 3 }}" aria-describedby="visitors-help-text" >
                            <p id="visitors-help-text" class="form-text text-muted">
                                <span id="visitors-display">3</span>
                                @lang('visitors')
                            </p>
                            @error('visitors')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="custom-question">
                                @lang('Custom question')
                            </label>
                            <input type="text" name="custom-question" id="custom-question" class="form-control @error('custom-question') is-invalid @enderror" maxlength="255" placeholder="What is your favourite colour?" value="{{ old('custom-question') }}" />
                            @error('custom-question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit"
                            class="btn btn-primary g-recaptcha" 
                            data-sitekey="{{ config('recaptcha.site-key') }}" 
                            data-callback='recaptchaCallback' 
                            data-action='submit'>
                            @lang('Create Turnip Queue')
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
<script type="text/javascript" src="{{ mix('js/queue/create.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
@endpush