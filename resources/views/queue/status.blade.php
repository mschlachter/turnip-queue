@extends('layouts.app')

@push('meta')
<meta name="robots" content="noindex">
<meta name="queue-token" content="{{ $turnipQueue->token }}">
<meta name="seeker-token" content="{{ $turnipSeeker->token }}">
<meta name="close-redirect" content="{{ route('queue.find') }}">
<meta name="boot-redirect" content="{{ route('queue.join', compact('turnipQueue')) }}">
<meta name="ping-route" content="{{ route('queue.ping', compact('turnipQueue')) }}">
<meta name="check-status" content="{{ $position > 0 }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">@lang('Turnip Queue')</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="status-in-queue" class="text-center @if($position <= 0) d-none @endif">
                        @lang('You are currently number')
                        <div class="h1" id="position-area"> 
                            {{ $position }}
                        </div>
                        @lang('in the queue')
                    </div>
                    <div id="status-show-dodo-code" class="text-center @if($position > 0) d-none @endif">
                        @lang('The Dodo Code to enter the island is:')
                        <div class="h1" id="dodo-code-area"> 
                            @if($position <= 0)
                            {{ $turnipQueue->dodo_code }}
                            @endif
                        </div>
                    </div>
                    <div class="alert alert-danger text-center">
                        @lang('Leave this window open until you have left the island.<br />Once you have left the island, click the button below to leave the queue.')
                    </div>
                    <p class="text-center">
                        @lang('Queue will expire:')
                        <span id="expiry-display" data-relative-from-timestamp="{{ $turnipQueue->expires_at->toISOString() }}">
                            {{ $turnipQueue->expires_at }}
                        </span>
                    </p>
                    <form class="text-center" method="post" action="{{ route('queue.leave', compact('turnipQueue')) }}" data-confirm="Are you sure you want to leave this Turnip Queue?">
                        @csrf
                        <button class="btn btn-outline-danger">
                            @lang('Leave the Queue')
                        </button>
                    </form>
                    <h2 id="messages-header" class="mt-3 @if($turnipQueue->turnipQueueMessages()->count() === 0) d-none @endif">
                        @lang('Messages from host')
                    </h2>
                    <div id="message-section">
                        @foreach($turnipQueue->turnipQueueMessages()->orderByDesc('sent_at')->get() as $turnipQueueMessage)
                        <div class="shadow-sm rounded border py-2 px-2 mb-3" id="queue-message-{{ $turnipQueueMessage->id }}">
                            <small class="text-muted" data-relative-from-timestamp="{{ $turnipQueueMessage->sent_at->toISOString() }}">
                                {{ $turnipQueueMessage->sent_at}}
                            </small>
                            <div class="message-text whitespace-preline">{{ $turnipQueueMessage->message }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript" src="{{ mix('js/queue/status.js') }}"></script>
@endpush