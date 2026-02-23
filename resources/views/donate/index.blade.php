@extends('layouts.app')

@section('title', __('Donate - Turnip Queue'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Donate')</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <p>
                        @lang('I\'m an independent developer who created this web application as a service to the community. Unfortunately, servers and some of the third-party services I use for this site come with a financial cost, so if you would like to help support the site with a monetary donation I would be eternally grateful.')
                    </p>
                    <p>
                        @lang('Donations will go toward costs associated with hosting (domain name, server droplet, server management software) and third-party services that are used for the operation of the site. If donations significantly offset these costs, I\'ll be able to upgrade the infrastructure and it\'ll also encourage me to spend more time developing and improving the site.')
                    </p>
                    <p>
                        <stripe-buy-button
                            buy-button-id="buy_btn_1T3yQOFcOXHjh5EpSCS5uYm7"
                            publishable-key="pk_live_51GyM74FcOXHjh5EpNlUQhXrtEmhaqgPL188lNObLB5EJfYT0YOs4G952UV08IcX1uQSgoTFChoWTGB3WjxhnPzCH002kBj3hCk"
                        ></stripe-buy-button>
                    </p>
                    <p>
                        @lang('Alternatively, if you would prefer to donate your time, you can help out with the project on GitHub. Whether it\'s reporting a bug you find, suggesting a feature, or contributing a fix or improvement, any help is welcome.')
                    </p>
                    <p>
                        <a class="btn btn-outline-secondary" href="https://github.com/mschlachter/turnip-queue" rel="noopener" target="_blank">
                            <span class="d-none d-sm-inline">View on GitHub</span>
                            <svg version="1.1" width="16" height="16" viewBox="0 0 16 16" class="octicon octicon-mark-github ms-1" aria-hidden="true" style="display: inline-block; vertical-align: -0.15rem;"><path fill-rule=evenodd d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"/></svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script async src="https://js.stripe.com/v3/buy-button.js"></script>
@endpush
