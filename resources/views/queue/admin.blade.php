@extends('layouts.app')

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
                        <a id="link-to-queue" href="{{ route('queue.join', compact('turnipQueue')) }}" target="_blank">
                            {{ route('queue.join', compact('turnipQueue')) }}
                        </a>
                    </p>
                    <p>
                        <button class="btn btn-outline-secondary mr-2" id="btn-copy-link">
                            <svg style="width:0.75rem;vertical-align: -0.125em;" aria-hidden="true" focusable="false" data-prefix="far" data-icon="clipboard" class="svg-inline--fa fa-clipboard fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M336 64h-80c0-35.3-28.7-64-64-64s-64 28.7-64 64H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zM192 40c13.3 0 24 10.7 24 24s-10.7 24-24 24-24-10.7-24-24 10.7-24 24-24zm144 418c0 3.3-2.7 6-6 6H54c-3.3 0-6-2.7-6-6V118c0-3.3 2.7-6 6-6h42v36c0 6.6 5.4 12 12 12h168c6.6 0 12-5.4 12-12v-36h42c3.3 0 6 2.7 6 6z"></path></svg>
                            Copy link
                        </button>
                        <a class="btn btn-outline-secondary" href="https://www.reddit.com/r/acturnips/submit?text=Link+to+the+queue:+{{ urlencode(route('queue.join', compact('turnipQueue'))) }}&url={{ urlencode(route('queue.join', compact('turnipQueue'))) }}" target="_blank" rel="noopener">
                            <svg style="width:1rem;vertical-align: -0.125em;" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="reddit" class="svg-inline--fa fa-reddit fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M201.5 305.5c-13.8 0-24.9-11.1-24.9-24.6 0-13.8 11.1-24.9 24.9-24.9 13.6 0 24.6 11.1 24.6 24.9 0 13.6-11.1 24.6-24.6 24.6zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-132.3-41.2c-9.4 0-17.7 3.9-23.8 10-22.4-15.5-52.6-25.5-86.1-26.6l17.4-78.3 55.4 12.5c0 13.6 11.1 24.6 24.6 24.6 13.8 0 24.9-11.3 24.9-24.9s-11.1-24.9-24.9-24.9c-9.7 0-18 5.8-22.1 13.8l-61.2-13.6c-3-.8-6.1 1.4-6.9 4.4l-19.1 86.4c-33.2 1.4-63.1 11.3-85.5 26.8-6.1-6.4-14.7-10.2-24.1-10.2-34.9 0-46.3 46.9-14.4 62.8-1.1 5-1.7 10.2-1.7 15.5 0 52.6 59.2 95.2 132 95.2 73.1 0 132.3-42.6 132.3-95.2 0-5.3-.6-10.8-1.9-15.8 31.3-16 19.8-62.5-14.9-62.5zM302.8 331c-18.2 18.2-76.1 17.9-93.6 0-2.2-2.2-6.1-2.2-8.3 0-2.5 2.5-2.5 6.4 0 8.6 22.8 22.8 87.3 22.8 110.2 0 2.5-2.2 2.5-6.1 0-8.6-2.2-2.2-6.1-2.2-8.3 0zm7.7-75c-13.6 0-24.6 11.1-24.6 24.9 0 13.6 11.1 24.6 24.6 24.6 13.8 0 24.9-11.1 24.9-24.6 0-13.8-11-24.9-24.9-24.9z"></path></svg>
                            Post to r/acturnips
                        </a>
                    </p>

                    <form id="form-queue-details" method="post" action="{{ route('queue.update', compact('turnipQueue')) }}">
                        @csrf
                        <div class="form-group">
                            <label for="dodo-code">
                                @lang('Dodo Code')
                            </label>
                            <input type="text" name="dodo-code" id="dodo-code" class="form-control @error('dodo-code') is-invalid @enderror" maxlength="8" placeholder="XXXXX" value="{{ $turnipQueue->dodo_code }}" />
                            @error('dodo-code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <p class="label">
                                @lang('Time Queue closes:')
                                <span id="queue-close-time" data-relative-from-timestamp="{{ $turnipQueue->expires_at->toISOString() }}" data-display-long="true">{{ $turnipQueue->expires_at }}</span>
                            </p>
                            <p>
                                <button type="submit" form="form-close-queue" class="btn btn-outline-danger">
                                    @lang('Close Queue now')
                                </button>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="visitors">
                                @lang('Visitors to allow at a time')
                            </label>
                            <input type="range" class="custom-range @error('visitors') is-invalid @enderror" min="1" max="10" step="1" id="visitors" name="visitors" value="{{ $turnipQueue->concurrent_visitors }}" aria-describedby="visitors-help-text" >
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
                            <input type="text" name="custom-question" id="custom-question" class="form-control @error('custom-question') is-invalid @enderror" maxlength="255" placeholder="What is your favourite colour?" value="{{ $turnipQueue->custom_question }}" />
                            @error('custom-question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            @lang('Update Queue details')
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            @lang('Cancel')
                        </button>
                    </form>
                    <form id="form-close-queue" method="post" action="{{ route('queue.close', compact('turnipQueue')) }}">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">@lang('Current Queue')</div>

                <div class="card-body">
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th>
                                    Reddit username
                                </th>
                                <th>
                                    In-game username
                                </th>
                                <th>
                                    Island name
                                </th>
                                <th>
                                    Custom answer
                                </th>
                                <th>
                                    Joined queue
                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody id="queue-table-body">
                            @foreach($turnipQueue->turnipSeekers as $seeker)
                            <tr>
                                <td>
                                    {{ $seeker->reddit_username }}
                                </td>
                                <td>
                                    {{ $seeker->in_game_username }}
                                </td>
                                <td>
                                    {{ $seeker->island_name }}
                                </td>
                                <td>
                                    {{ $seeker->custom_answer }}
                                </td>
                                <td data-relative-from-timestamp="{{ $seeker->joined_queue->toISOString() }}">
                                    {{ $seeker->joined_queue }}
                                </td>
                                <td>
                                    {{ $loop->index < $turnipQueue->concurrent_visitors ? __('Has code') : __('In queue') }}
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
<script type="text/javascript">
    var queueDetailsForm = document.getElementById("form-queue-details");
    var visitorSlider = document.getElementById("visitors");
    var visitorOutput = document.getElementById("visitors-display");
    visitorOutput.innerHTML = visitorSlider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    visitorSlider.oninput = function() {
      visitorOutput.innerHTML = this.value;
    }

    queueDetailsForm.onreset = function() {
        setTimeout(function() {
            visitorOutput.innerHTML = visitorSlider.value;
        }, 1);
    }

    // Listen for events (updates the list, in this case)
    Echo.private('App.TurnipQueue.{{ $turnipQueue->token }}')
        .listen('QueueChanged', function(e) {
            var seekers = e.newQueue;

            // Construct the new tbody
            var newTBody = document.createElement('tbody');
            for(i = 0; i < seekers.length; i++) {
                var seekerRow = document.createElement('tr');

                var reddit_username_row = document.createElement('td');
                reddit_username_row.innerText = seekers[i].reddit_username;
                seekerRow.appendChild(reddit_username_row);

                var ingame_username_row = document.createElement('td');
                ingame_username_row.innerText = seekers[i].in_game_username;
                seekerRow.appendChild(ingame_username_row);

                var island_name_row = document.createElement('td');
                island_name_row.innerText = seekers[i].island_name;
                seekerRow.appendChild(island_name_row);

                var custom_answer_row = document.createElement('td');
                custom_answer_row.innerText = seekers[i].custom_answer;
                seekerRow.appendChild(custom_answer_row);

                var joined_queue_row = document.createElement('td');
                joined_queue_row.innerText = timeToGo(seekers[i].joined_queue);
                joined_queue_row.setAttribute('data-relative-from-timestamp', seekers[i].joined_queue);
                seekerRow.appendChild(joined_queue_row);

                var status_row = document.createElement('td');
                status_row.innerText = i < e.concurrentVisitors ? 'Has code' : 'In queue';
                seekerRow.appendChild(status_row);

                newTBody.appendChild(seekerRow);
            }

            // Update the table body:
            var curTableBody = document.getElementById('queue-table-body');
            curTableBody.innerHTML = newTBody.innerHTML;
        });

    // Detect a 'queue closed' event
    Echo.channel('App.TurnipQueue.{{ $turnipQueue->token }}')
        .listen('QueueClosed', function(e) {
            alert('The Queue has expired.');
            window.location.href = '{{ route('queue.create') }}';
        });

    // Copy to clipboard button:
    function fallbackCopyTextToClipboard(text, button) {
        var textArea = document.createElement("textarea");
        textArea.value = text;

        // Avoid scrolling to bottom
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        textArea.setSelectionRange(0, 99999);

        try {
            var successful = document.execCommand('copy');
            if(successful) {
                textCopied(text, button);
            } else {
                console.log('Fallback: Copying text command was unsuccessful');
            }
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }
        document.body.removeChild(textArea);
    }
    function copyTextToClipboard(text, button) {
        if (!navigator.clipboard) {
            fallbackCopyTextToClipboard(text, button);
            return;
        }
        navigator.clipboard.writeText(text).then(function() {
            textCopied(text, button);
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
        });
    }
    function textCopied(text, button) {
        alert('Copied to clipboard: ' + text);
        button.focus();
    }

    document.getElementById('btn-copy-link').onclick = function() {
        var link = document.getElementById('link-to-queue').href;
        copyTextToClipboard(link, this);
    }

    // Use 'time to go' logic for the close time
    function isoToObj(s) {
        var b = s.split(/[-TZ:]/i);

        return new Date(Date.UTC(b[0], --b[1], b[2], b[3], b[4], b[5]));

    }

    function timeToGo(s, l) {
        // Utility to add leading zero
        function z(n) {
          return (n < 10? '0' : '') + n;
        }

        // Convert string to date object
        var d = isoToObj(s);
        var diff = d - new Date();

        // Allow for previous times
        var sign = diff < 0? '-' : '';
        diff = Math.abs(diff);

        // Get time components
        var hours = diff/3.6e6 | 0;
        var mins  = diff%3.6e6 / 6e4 | 0;
        var secs  = Math.round(diff%6e4 / 1e3);

        if(l) {
            // return formatted string
            return sign + ' ' + z(hours) + ' hours, ' + z(mins) + ' minutes, ' + z(secs) + ' seconds';   
        }
        return z(hours) + ':' + z(mins) + ':' + z(secs);
    }

    var closeTime = document.getElementById('queue-close-time').innerText;
    var timeDisplay = document.getElementById('queue-close-time');

    window.setInterval(function() {
        document.querySelectorAll('[data-relative-from-timestamp]').forEach(function(element) {
            element.innerText = timeToGo(
                element.getAttribute('data-relative-from-timestamp'),
                element.getAttribute('data-display-long') === 'true',
            );
        });
    }, 1000);
</script>
@endpush