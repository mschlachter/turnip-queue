@extends('layouts.app')

@section('title', __('Contact Us - Turnip Queue'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Contact Us')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form id="form-message" method="post" action="{{ route('info.send-message') }}">
                        @csrf
                        <p>
                            @lang('All fields are required unless marked optional.')
                        </p>
                        <div class="mb-3">
                            <label for="email">
                                @lang('Your email address')
                            </label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" maxlength="255" placeholder="you@domain.com" value="{{ old('email') }}" />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="subject">
                                @lang('Subject')
                            </label>
                            <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" maxlength="255" placeholder="Feedback/Question/Etc." value="{{ old('subject') }}" />
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="message">
                                @lang('Message')
                            </label>
                            <textarea type="text" name="message" id="message" class="form-control @error('message') is-invalid @enderror" placeholder="">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 form-text text-muted small">
                            @lang('This form is protected by reCAPTCHA and the Google
<a target="_blank" rel="noopener" href="https://policies.google.com/privacy">Privacy Policy</a> and
<a target="_blank" rel="noopener" href="https://policies.google.com/terms">Terms of Service</a> apply.')
                        </div>
                        <button type="submit"
                            class="btn btn-primary g-recaptcha"
                            data-sitekey="{{ config('recaptcha.site-key') }}"
                            data-callback='recaptchaCallback'
                            data-action='submit'>
                            @lang('Send Message')
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
<script src="https://www.recaptcha.net/recaptcha/api.js"></script>
<script type="text/javascript">
// Recaptcha success callback
window.recaptchaCallback = function(token) {
	document.getElementById('form-message').submit();
}
</script>
@endpush
