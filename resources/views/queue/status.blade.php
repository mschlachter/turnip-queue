@extends('layouts.app')

@push('meta')
<meta name="robots" content="noindex">
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
                        @lang('Leave this window open until you have left the island.<br />Once you have left the island, click the button below:')
                    </div>
                    <form class="text-center" method="post" action="{{ route('queue.leave', compact('turnipQueue')) }}">
                        @csrf
                        <button class="btn btn-outline-danger">
                            @lang('Leave the Queue')
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
    // Detect a 'queue closed' event
    var queueChannel = Echo.channel('App.TurnipQueue.{{ $turnipQueue->token }}');

    queueChannel.listen('QueueClosed', function(e) {
        // Show a notification to say the queue was closed
        alert('The Queue has been closed by the host.');
        window.location.href = '{{ route('queue.join', compact('turnipQueue')) }}';
    });

    // Events for position changed or booted from queue
    var seekerChannel = Echo.private('App.TurnipSeeker.{{ $turnipSeeker->token }}');

    @if($position > 0)
    seekerChannel.listen('StatusChanged', function(e) {
        console.log(e);
        if(e.position <= 0) {
            // We reached the end of the queue!
            document.getElementById('dodo-code-area').innerText = e.dodoCode;
            document.getElementById('status-show-dodo-code').classList.remove('d-none');
            document.getElementById('status-in-queue').classList.add('d-none');

            // Play a notification sound
            var notification = new Audio('/sounds/notification-sound.mp3');
            notification.play();

            // Blink the title if the window is inactive
            blinkTitle('Dodo code received');

            // Stop listening to this specific event:
            seekerChannel.stopListening('StatusChanged');
        } else {
            document.getElementById('position-area').innerText = e.position;
        }
    });
    @endif

    seekerChannel.listen('SeekerBooted', function(e) {
        // Show a notification to say the queue was closed
        alert('You have been removed from the Queue.');
        window.location.href = '{{ route('queue.join', compact('turnipQueue')) }}';
    });

    // Ping the server every 30 seconds to remain in the queue
    function maintainSession() {
        var xmlHttp = new XMLHttpRequest();
        // We don't use this for now but maybe in the future ...?
        // xmlHttp.onreadystatechange = function() { 
            // if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
                // result = JSON.parse(xmlHttp.responseText).result;
            // }
        // }
        xmlHttp.open("GET", "{{ route('queue.ping', compact('turnipQueue')) }}", true); // true for asynchronous 
        xmlHttp.send(null);
    }

    window.setInterval(maintainSession, 30 * 1000);

    // Functions to blink the title when out of focus (when needed)
    var timer = "";
    var isBlurred = false;
    var originalTitle = document.querySelector('title').innerText;
    window.onblur = function() {
        isBlurred = true;
    }
    window.onfocus = function() { 
        isBlurred = false;
        document.title = originalTitle;
        clearInterval(timer);
    }
    function blinkTitle(text) {
        clearInterval(timer);
        if(isBlurred) {
            timer = window.setInterval(function() {
                document.title = document.title == originalTitle ? text : originalTitle;
            }, 1000);
        }
    }
</script>
@endpush