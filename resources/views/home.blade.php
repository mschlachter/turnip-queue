@extends('layouts.app')

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
                                    <source srcset="{{ asset('img/Daisy_Mae_NH.webp') }}" type="image/webp">
                                    <source srcset="{{ asset('img/Daisy_Mae_NH.png') }}" type="image/png">
                                    <img src="{{ asset('img/Daisy_Mae_NH.png') }}" width="215" height="310" alt="Daisy Mae" />
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
                                @lang('Turnip Queue provides an automated way for you to invite a large number of people to your island on Animal Crossing: New Horizons, a few people at a time.')
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
                                    <source srcset="{{ asset('img/Visitor_Group.webp') }}" type="image/webp">
                                    <source srcset="{{ asset('img/Visitor_Group.jpg') }}" type="image/jpeg">
                                    <img class="mw-100" src="{{ asset('img/Visitor_Group.jpg') }}" alt="Group of Villagers around a picnic table" />
                                </picture>
                                <figcaption class="text-left text-md-center">
                                    <small>
                                        @lang('Image credit: Nintendo')
                                    </small>
                                </figcaption>
                            </figure>
                            <figure class="d-none d-md-block">
                                <picture>
                                    <source srcset="{{ asset('img/Daisy_Mae_Selling.webp') }}" type="image/webp">
                                    <source srcset="{{ asset('img/Daisy_Mae_Selling.jpg') }}" type="image/jpeg">
                                    <img class="mw-100" src="{{ asset('img/Daisy_Mae_Selling.jpg') }}" alt="Daisy Mae Selling Turnips" />
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
                                        @lang('Once your Queue is opened, you\'ll be given a link; only people who have the link will be able to join your Turnip Queue. Post your link to <a href="https://reddit.com/r/acturnips" rel="noopener" target="_blank">r/acturnips</a> or anywhere else where you would like to invite people from.')
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
