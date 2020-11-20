@extends('layouts.app')

@section('title', __('Turnip Queue: Simplifying the Turnip Economy'))
@section('meta-description', __('Designed to optimize the workflow of r/acturnips, Turnip Queue automates letting a few people at a time onto your island in Animal Crossing: New Horizons.'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-5 order-md-2 text-center">
                            <figure>
                                <picture>
                                    <source srcset="{{ asset('img/Daisy_Mae_NH.webp') }} 1x, {{ asset('img/Daisy_Mae_NH_x2.webp') }} 2x, {{ asset('img/Daisy_Mae_NH_x4.webp') }} 4x" type="image/webp"/>
                                    <source srcset="{{ asset('img/Daisy_Mae_NH.png') }} 1x, {{ asset('img/Daisy_Mae_NH_x2.png') }} 2x, {{ asset('img/Daisy_Mae_NH_x4.png') }} 4x" type="image/png"/>
                                    <img src="{{ asset('img/Daisy_Mae_NH.png') }}" width="215" height="310" alt="Daisy Mae" style="margin-left: 15%;" />
                                </picture>
                                <figcaption class="text-left text-md-center">
                                    <small>
                                        @lang('Image credit: Nintendo')
                                    </small>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-md-7 order-md-1">
                            <h1>
                                @lang('Simplifying the Turnip Economy')
                            </h1>
                            <h2 class="h5 mb-4">
                                @lang('Turnip Queue automates letting a few people at a time onto your island in Animal Crossing: New Horizons.')
                            </h2>
                            <p>
                                @lang('<strong>Open a free account</strong> and start creating Queues now.')
                            </p>
                            <p>
                                <a class="btn btn-primary" href="{{ route('register') }}">
                                    @lang('Sign up now')
                                </a>
                            </p>
                            <p class="mb-5">
                                <small>
                                    @lang('Membership needed to open a Queue, no account needed to join an existing Queue.')
                                </small>
                            </p>
                        </div>
                        <div class="col-md-4 order-md-3 text-center pt-5 d-flex flex-row flex-md-column justify-content-around">
                            <figure>
                                <picture>
                                    <source srcset="{{ asset('img/Visitor_Group.webp') }}" type="image/webp"/>
                                    <source srcset="{{ asset('img/Visitor_Group.jpg') }}" type="image/jpeg"/>
                                    <img class="mw-100 h-auto" src="{{ asset('img/Visitor_Group.jpg') }}" alt="Group of Villagers around a picnic table" loading="lazy" width="468" height="263" />
                                </picture>
                                <figcaption class="text-left text-md-center">
                                    <small>
                                        @lang('Image credit: Nintendo')
                                    </small>
                                </figcaption>
                            </figure>
                            <figure class="d-none d-md-block">
                                <picture>
                                    <source srcset="{{ asset('img/Daisy_Mae_Selling.webp') }}" type="image/webp"/>
                                    <source srcset="{{ asset('img/Daisy_Mae_Selling.jpg') }}" type="image/jpeg"/>
                                    <img class="mw-100 h-auto" src="{{ asset('img/Daisy_Mae_Selling.jpg') }}" alt="Daisy Mae Selling Turnips" loading="lazy" width="720" height="405" />
                                </picture>
                                <figcaption class="text-left text-md-center">
                                    <small>
                                        @lang('Image credit: Nintendo')
                                    </small>
                                </figcaption>
                            </figure>
                        </div>
                        <div class="col-md-8 order-md-4">
                            <p>
                                @lang('Designed to optimize the workflow for <a href="https://reddit.com/r/acturnips" rel="noopener" target="_blank">r/acturnips</a>, Turnip Queue has a simple three-step flow for automating island visitor management:')
                            </p>
                            <ol>
                                <li>
                                    <p>
                                        <strong>@lang('Create a Queue')</strong>
                                    </p>
                                    <p>
                                        @lang('Enter the Dodo Code, how long to keep the Queue open, how many people should be let in at a time, and a custom question to ask potential queuees.')
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        <strong>@lang('Send or post the link to your Queue')</strong>
                                    </p>
                                    <p>
                                        @lang('Once your Queue is opened, you\'ll be given a link; only people who have the link will be able to join your Turnip Queue by filling out a short form with their Reddit username, in-game username, island name, and an answer to your custom question.')
                                    </p>
                                    <p>
                                        @lang('Post your link to <a href="https://reddit.com/r/acturnips" rel="noopener" target="_blank">r/acturnips</a> or anywhere else from which you would like to invite people.')
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        <strong>@lang('Focus on your island and let the Queue take care of letting people in')</strong>
                                    </p>
                                    <p>
                                        @lang('From there, the whole process is automated, from displaying your Dodo Code to the people who\'ve reached the end of the Queue, to closing the Queue when the time is up and even blocking bots.')
                                    </p>
                                    <p>
                                        @lang('You stay in control, with options to close the Queue at any time, send messages to the people waiting in the Queue, update the Dodo Code if needed, and even give the boot to queuees that you don\'t want visiting your island.')
                                    </p>
                                </li>
                            </ol>
                        </div>
                        <div class="col-md-8 order-md-5 offset-md-4">
                            <p class="ml-ol">
                                <a class="btn btn-primary" href="{{ route('register') }}">
                                    @lang('Sign up now')
                                </a>
                            </p>
                            <p class="mb-5 ml-ol">
                                <small>
                                    @lang('Membership needed to open a Queue, no account needed to join an existing Queue.')
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "{{  route('home') }}"
    }
</script>
@endpush
