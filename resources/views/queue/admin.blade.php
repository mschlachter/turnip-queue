@extends('layouts.app')

@section('title', __('Queue Details - Turnip Queue'))

@push('meta')
    <meta name="queue-token" content="{{ $turnipQueue->token }}">
    <meta name="expire-redirect" content="{{ route('queue.create') }}">
    <meta name="boot-route" content="{{ route('queue.boot-seeker') }}">
    <meta name="current-queue-route" content="{{ route('queue.current-queue', compact('turnipQueue')) }}">
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('Queue Details')</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <p>
                            Link to join Queue:
                            <a id="link-to-queue" href="{{ route('queue.join', compact('turnipQueue')) }}"
                               target="_blank">
                                {{ route('queue.join', compact('turnipQueue')) }}
                            </a>
                        </p>
                        <div>
                            <button class="btn btn-outline-secondary me-2 mb-3" id="btn-copy-link">
                                <svg style="width:0.75rem;vertical-align: -0.125em;" aria-hidden="true"
                                     focusable="false" data-prefix="far" data-icon="clipboard"
                                     class="svg-inline--fa fa-clipboard fa-w-12" role="img"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path fill="currentColor"
                                          d="M336 64h-80c0-35.3-28.7-64-64-64s-64 28.7-64 64H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM192 40c13.3 0 24 10.7 24 24s-10.7 24-24 24-24-10.7-24-24 10.7-24 24-24zm144 418c0 3.3-2.7 6-6 6H54c-3.3 0-6-2.7-6-6V118c0-3.3 2.7-6 6-6h42v36c0 6.6 5.4 12 12 12h168c6.6 0 12-5.4 12-12v-36h42c3.3 0 6 2.7 6 6z"></path>
                                </svg>
                                Copy link
                            </button>
                            <a class="btn btn-outline-secondary mb-3"
                               href="https://www.reddit.com/r/acturnips/submit?text=Link+to+the+queue:+{{ urlencode(route('queue.join', compact('turnipQueue'))) }}&url={{ urlencode(route('queue.join', compact('turnipQueue'))) }}"
                               target="_blank" rel="noopener">
                                <svg style="width:1rem;vertical-align: -0.125em;" aria-hidden="true" focusable="false"
                                     data-prefix="fab" data-icon="reddit" class="svg-inline--fa fa-reddit fa-w-16"
                                     role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                          d="M201.5 305.5c-13.8 0-24.9-11.1-24.9-24.6 0-13.8 11.1-24.9 24.9-24.9 13.6 0 24.6 11.1 24.6 24.9 0 13.6-11.1 24.6-24.6 24.6zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-132.3-41.2c-9.4 0-17.7 3.9-23.8 10-22.4-15.5-52.6-25.5-86.1-26.6l17.4-78.3 55.4 12.5c0 13.6 11.1 24.6 24.6 24.6 13.8 0 24.9-11.3 24.9-24.9s-11.1-24.9-24.9-24.9c-9.7 0-18 5.8-22.1 13.8l-61.2-13.6c-3-.8-6.1 1.4-6.9 4.4l-19.1 86.4c-33.2 1.4-63.1 11.3-85.5 26.8-6.1-6.4-14.7-10.2-24.1-10.2-34.9 0-46.3 46.9-14.4 62.8-1.1 5-1.7 10.2-1.7 15.5 0 52.6 59.2 95.2 132 95.2 73.1 0 132.3-42.6 132.3-95.2 0-5.3-.6-10.8-1.9-15.8 31.3-16 19.8-62.5-14.9-62.5zM302.8 331c-18.2 18.2-76.1 17.9-93.6 0-2.2-2.2-6.1-2.2-8.3 0-2.5 2.5-2.5 6.4 0 8.6 22.8 22.8 87.3 22.8 110.2 0 2.5-2.2 2.5-6.1 0-8.6-2.2-2.2-6.1-2.2-8.3 0zm7.7-75c-13.6 0-24.6 11.1-24.6 24.9 0 13.6 11.1 24.6 24.6 24.6 13.8 0 24.9-11.1 24.9-24.6 0-13.8-11-24.9-24.9-24.9z"></path>
                                </svg>
                                Post to r/acturnips
                            </a>
                        </div>
                        <div class="mb-3">
                            <p class="label">
                                @lang('Queue will expire:')
                                <span id="expiry-display"
                                      data-relative-from-timestamp="{{ $turnipQueue->expires_at->toISOString() }}"
                                      data-display-long="true">{{ $turnipQueue->expires_at }}</span>
                            </p>
                            <div>
                                <form class="d-inline" id="form-add-half-hour" method="post"
                                      action="{{ route('queue.add-half-hour', compact('turnipQueue')) }}"
                                      data-confirm="Are you sure you want to add half an hour to the expiry time?">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary me-2 mb-3">
                                        @lang('Add half-hour')
                                    </button>
                                </form>
                                <form class="d-inline" id="form-close-queue" method="post"
                                      action="{{ route('queue.close', compact('turnipQueue')) }}"
                                      data-confirm="Are you sure you want to close this Queue?">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger mb-3">
                                        @lang('Close Queue now')
                                    </button>
                                </form>
                            </div>
                        </div>

                        <form id="form-queue-details" method="post"
                              action="{{ route('queue.update', compact('turnipQueue')) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="dodo-code">
                                    @lang('Dodo Code')
                                </label>
                                <input type="text" name="dodo-code" id="dodo-code"
                                       class="form-control @error('dodo-code') is-invalid @enderror" maxlength="8"
                                       placeholder="XXXXX" value="{{ $turnipQueue->dodo_code }}"/>
                                @error('dodo-code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="visitors">
                                    @lang('Visitors to allow at a time')
                                </label>
                                <input type="range" class="custom-range @error('visitors') is-invalid @enderror" min="1"
                                       max="10" step="1" id="visitors" name="visitors"
                                       value="{{ $turnipQueue->concurrent_visitors }}"
                                       aria-describedby="visitors-help-text">
                                <p id="visitors-help-text" class="form-text text-muted">
                                    <span id="visitors-display">3</span>
                                    @lang('visitors')
                                </p>
                                @error('visitors')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="ask-reddit-username" id="ask-reddit-username"
                                           class="form-check-input" value="1"
                                           @if($turnipQueue->ask_reddit_username)checked="checked"@endif/>
                                    <label for="ask-reddit-username" class="form-check-label">
                                        @lang('Ask for Reddit username')
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="custom-question">
                                    @lang('Custom question (optional)')
                                </label>
                                <input type="text" name="custom-question" id="custom-question"
                                       class="form-control @error('custom-question') is-invalid @enderror"
                                       maxlength="255" placeholder="What is your favourite colour?"
                                       value="{{ $turnipQueue->custom_question }}"/>
                                @error('custom-question')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary me-2 mt-3">
                                @lang('Update Queue details')
                            </button>
                            <button type="reset" class="btn btn-outline-secondary mt-3">
                                @lang('Cancel')
                            </button>
                        </form>
                    </div>
                </div>


                <div class="card mt-3">
                    <div class="card-header">@lang('Send message to Queue')</div>

                    <div class="card-body">
                        <div id="message-section" class="mb-3">
                            @foreach($turnipQueue->turnipQueueMessages as $turnipQueueMessage)
                                <div class="shadow-sm rounded border py-2 px-2 mb-3"
                                     id="queue-message-{{ $turnipQueueMessage->id }}">
                                    <form method="post"
                                          action="{{ route('message.destroy', compact('turnipQueueMessage')) }}"
                                          class="form-delete-message">
                                        @csrf
                                        <button type="submit" class="btn btn-link float-end btn-sm">
                                            @lang('Delete message')
                                        </button>
                                    </form>
                                    <small class="text-muted"
                                           data-relative-from-timestamp="{{ $turnipQueueMessage->sent_at->toISOString() }}">
                                        {{ $turnipQueueMessage->sent_at }}
                                    </small>
                                    <div
                                        class="message-text whitespace-preline">{{ $turnipQueueMessage->message }}</div>
                                </div>
                            @endforeach
                        </div>
                        <form id="form-send-message" method="post" action="{{ route('message.store') }}">
                            @csrf
                            <input type="hidden" name="queue-token" value="{{ $turnipQueue->token }}">
                            <div class="mb-3">
                                <label for="message-text">
                                    @lang('Message text')
                                </label>
                                <textarea id="message-text" name="message"
                                          class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                @lang('Send message')
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                            <div class="row">
                            <span class="col mr-auto">
                                @lang('Current Queue')
                            </span>
                            <button class="btn btn-outline-secondary col-auto ml-auto btn-sm" type="button" onclick="document.querySelectorAll('#current-queue-table,#current-queue-list').forEach(x => {x.classList.toggle('show')})">
                                Toggle display
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="d-none" id="queue-list-template">
                            <x-queue.queue-member :seeker="$templateSeeker" :turnipQueue="$turnipQueue"/>
                        </div>
                        <div class="collapse show" id="current-queue-list">
                            @foreach($turnipQueue->turnipSeekers as $seeker)
                                <x-queue.queue-member :seeker="$seeker" :turnipQueue="$turnipQueue"/>
                            @endforeach
                        </div>
                        <table class="table w-100 collapse" id="current-queue-table">
                            <thead>
                            <tr>
                                @if($turnipQueue->ask_reddit_username)
                                    <th id="reddit-username-header">
                                        Reddit username
                                    </th>
                                @endif
                                <th>
                                    In-game name / island name
                                </th>
                                @if(!is_null($turnipQueue->custom_question))
                                    <th id="custom-answer-header">
                                        Custom answer
                                    </th>
                                @endif
                                <th>
                                    Joined queue
                                </th>
                                <th>
                                    Rcvd. Code
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    <span class="visually-hidden">
                                        Actions
                                    </span>
                                </th>
                            </tr>
                            </thead>
                            <tbody id="queue-table-body">
                            @foreach($turnipQueue->turnipSeekers as $seeker)
                                <tr>
                                    @if($turnipQueue->ask_reddit_username)
                                        <td>
                                            {{ $seeker->reddit_username }}
                                        </td>
                                    @endif
                                    <td>
                                        {{ $seeker->in_game_username }}
                                        from
                                        {{ $seeker->island_name }}
                                    </td>
                                    @if(!is_null($turnipQueue->custom_question))
                                        <td>
                                            {{ $seeker->custom_answer }}
                                        </td>
                                    @endif
                                    <td data-relative-from-timestamp="{{ $seeker->joined_queue->toISOString() }}">
                                        {{ $seeker->joined_queue }}
                                    </td>
                                    <td @if($seeker->received_code)data-relative-from-timestamp="{{ $seeker->received_code->toISOString() }}"@endif>
                                        {{ $seeker->received_code }}
                                    </td>
                                    <td>
                                        {{ $seeker->received_code ? __('Has code') : __('In queue') }}
                                    </td>
                                    <td>
                                        <form class="form-boot-seeker"
                                              data-confirm="Are you sure you want to remove {{ $seeker->reddit_username }} from the Queue?"
                                              method="post" action="{{ route('queue.boot-seeker') }}">
                                            @csrf
                                            <input type="hidden" name="queue-token" value="{{ $turnipQueue->token }}">
                                            <input type="hidden" name="seeker-token" value="{{ $seeker->token }}">
                                            <button type="submit" class="btn btn-outline-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{ mix('js/queue/admin.js') }}"></script>
@endpush
