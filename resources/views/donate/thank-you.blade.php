@extends('layouts.app')

@section('title', __('Thank You - Turnip Queue'))

@push('meta')
<meta name="robots" content="noindex">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Thank you for donating')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        @lang('Thank you very much for donating! As I said on the main donation page, I\'m eternally grateful for your support.')
                    </p>
                    <p>
                        @lang('Donations will go toward costs associated with hosting (domain name, server droplet, server management software) and third-party services that are used for the operation of the site. If donations significantly offset these costs, I\'ll be able to upgrade the infrastructure and it\'ll also encourage me to spend more time developing and improving the site.')
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
