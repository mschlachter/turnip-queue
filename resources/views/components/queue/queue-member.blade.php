<div class="queue-member row" id="member-{{ $seeker->token }}">
    <div class="col">
        <div class="user-island h5">
            <strong class="in-game-username">{{ $seeker->in_game_username }}</strong>
            from
            <strong class="island-name">{{ $seeker->island_name }}</strong>
        </div>
        @if($turnipQueue->ask_reddit_username)
            <div class="reddit-username">
                Reddit Username:
                <strong class="reddit-username-text">{{ $seeker->reddit_username }}</strong>
            </div>
        @endif
        @if(!is_null($turnipQueue->custom_question))
            <div class="custom-question">
                <div class="question-text small">
                    {{ $turnipQueue->custom_question }}
                </div>
                <div class="answer-text">
                    {{ $seeker->custom_answer }}
                </div>
            </div>
        @endif
    </div>
    <div class="col-auto text-end height-full d-flex flex-column">
        <div class="queue-status mb-auto">
            <span class="bg-success px-2 small rounded-pill mr-2 d-none">&nbsp;</span>
            <strong class="queue-status-text">{{ $seeker->received_code ? __('Has code') : __('In queue') }}</strong>
            @if($seeker->received_code)
                <span class="queue-status-time" data-relative-from-timestamp="{{ $seeker->received_code->toISOString() }}">
                    {{ $seeker->received_code }}
                </span>
            @else
                <span class="queue-status-time" data-relative-from-timestamp="{{ optional($seeker->joined_queue)->toISOString() }}">
                    {{ $seeker->joined_queue }}
                </span>
            @endif
        </div>
        <div class="remove-button mt-auto pt-1">
            <form class="form-boot-seeker"
                    data-confirm="Are you sure you want to remove {{ $seeker->in_game_username }} from the Queue?"
                    method="post" action="{{ route('queue.boot-seeker') }}">
                @csrf
                <input type="hidden" name="queue-token" value="{{ $turnipQueue->token }}">
                <input type="hidden" class="seeker-token" name="seeker-token" value="{{ $seeker->token }}">
                <button type="submit" class="btn btn-outline-danger">Remove</button>
            </form>
        </div>
    </div>
</div>
