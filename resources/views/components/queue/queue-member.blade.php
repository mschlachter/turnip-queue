<div class="queue-member row" id="member-{{ $seeker->token }}">
    <div class="col-auto">
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
    <div class="col-12 col-lg text-lg-end height-full d-flex flex-lg-column flex-row">
        <div class="queue-status d-relative mb-lg-auto mt-auto mt-lg-0">
            <strong class="queue-status-text">{{ $seeker->received_code ? __('Received code:') : __('Waiting in queue...') }}</strong>
            @if($seeker->received_code)
                <span class="queue-status-time" data-relative-from-timestamp="{{ $seeker->received_code->toISOString() }}">
                    {{ now()->diff($seeker->received_code)->format('%H:%i:%s') }}
                </span>
            @else
                <span class="queue-status-time" data-relative-from-timestamp="{{ optional($seeker->joined_queue)->toISOString() }}">
                    {{ now()->diff($seeker->joined_queue)->format('%H:%i:%s') }}
                </span>
            @endif
            <div class="queue-active-indicator d-inline" data-last-ping="{{ optional($seeker->last_ping)->toISOString() }}">
                <span style="width: 1.2rem; height: 1.2rem;" title="connected" class="queue-connected-icon text-success d-inline-block ms-1 @unless($seeker->getIsActive()) d-none @endunless">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M451.5 160C434.9 160 418.8 164.5 404.7 172.7C388.9 156.7 370.5 143.3 350.2 133.2C378.4 109.2 414.3 96 451.5 96C537.9 96 608 166 608 252.5C608 294 591.5 333.8 562.2 363.1L491.1 434.2C461.8 463.5 422 480 380.5 480C294.1 480 224 410 224 323.5C224 322 224 320.5 224.1 319C224.6 301.3 239.3 287.4 257 287.9C274.7 288.4 288.6 303.1 288.1 320.8C288.1 321.7 288.1 322.6 288.1 323.4C288.1 374.5 329.5 415.9 380.6 415.9C405.1 415.9 428.6 406.2 446 388.8L517.1 317.7C534.4 300.4 544.2 276.8 544.2 252.3C544.2 201.2 502.8 159.8 451.7 159.8zM307.2 237.3C305.3 236.5 303.4 235.4 301.7 234.2C289.1 227.7 274.7 224 259.6 224C235.1 224 211.6 233.7 194.2 251.1L123.1 322.2C105.8 339.5 96 363.1 96 387.6C96 438.7 137.4 480.1 188.5 480.1C205 480.1 221.1 475.7 235.2 467.5C251 483.5 269.4 496.9 289.8 507C261.6 530.9 225.8 544.2 188.5 544.2C102.1 544.2 32 474.2 32 387.7C32 346.2 48.5 306.4 77.8 277.1L148.9 206C178.2 176.7 218 160.2 259.5 160.2C346.1 160.2 416 230.8 416 317.1C416 318.4 416 319.7 416 321C415.6 338.7 400.9 352.6 383.2 352.2C365.5 351.8 351.6 337.1 352 319.4C352 318.6 352 317.9 352 317.1C352 283.4 334 253.8 307.2 237.5z"/></svg>
                </span>
                <span style="width: 1.2rem; height: 1.2rem;" title="disconnected" class="queue-disconnected-icon text-danger d-inline-block ms-1 @if($seeker->getIsActive()) d-none @endif">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M73 39.1C63.6 29.7 48.4 29.7 39.1 39.1C29.8 48.5 29.7 63.7 39 73.1L567 601.1C576.4 610.5 591.6 610.5 600.9 601.1C610.2 591.7 610.3 576.5 600.9 567.2L478.9 445.2C483.1 441.8 487.2 438.1 491 434.3L562.1 363.2C591.4 333.9 607.9 294.1 607.9 252.6C607.9 166.2 537.9 96.1 451.4 96.1C414.1 96.1 378.3 109.4 350.1 133.3C370.4 143.4 388.8 156.8 404.6 172.8C418.7 164.5 434.8 160.1 451.4 160.1C502.5 160.1 543.9 201.5 543.9 252.6C543.9 277.1 534.2 300.6 516.8 318L445.7 389.1C441.8 393 437.6 396.5 433.1 399.6L385.6 352.1C402.1 351.2 415.3 337.7 415.8 321C415.8 319.7 415.8 318.4 415.8 317.1C415.8 230.8 345.9 160.2 259.3 160.2C240.1 160.2 221.4 163.7 203.8 170.4L73 39.1zM257.9 224C258.5 224 259 224 259.6 224C274.7 224 289.1 227.7 301.7 234.2C303.5 235.4 305.3 236.5 307.2 237.3C334 253.6 352 283.2 352 316.9C352 317.3 352 317.7 352 318.1L257.9 224zM378.2 480L224 325.8C225.2 410.4 293.6 478.7 378.1 479.9zM171.7 273.5L126.4 228.2L77.8 276.8C48.5 306.1 32 345.9 32 387.4C32 473.8 102 543.9 188.5 543.9C225.7 543.9 261.6 530.6 289.8 506.7C269.5 496.6 251 483.2 235.2 467.2C221.2 475.4 205.1 479.8 188.5 479.8C137.4 479.8 96 438.4 96 387.3C96 362.8 105.7 339.3 123.1 321.9L171.7 273.3z"/></svg>
                </span>
            </div>
        </div>
        <div class="remove-button mt-auto pt-2 flex-grow-1 flex-lg-grow-0 text-end">
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
