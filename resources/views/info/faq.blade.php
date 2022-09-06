@extends('layouts.app')

@section('title', __('FAQ - Turnip Queue'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>@lang('Frequently Asked Questions')</h1>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <details class="card mb-3">
                <summary class="card-header">@lang('Why is my position in a Queue not updating?')</summary>

                <div class="card-body">
                    <p>
                        It's common for queues to move slowly, please be patient while waiting in a Queue.
                    </p>
                    <p>
                        If you find that your position is not updating automatically, it may be because JavaScript is disabled in your web browser. Please check your browser settings to confirm that JavaScript is enabled.
                    </p>
                    <p>
                        If your position in the Queue doesn't update automatically but does update when you refresh the page, please submit a bug report either through <a href="https://github.com/mschlachter/turnip-queue/issues" target="_blank" rel="noopener">GitHub</a> or by filling out our <a href="{{ route('info.contact') }}">contact form</a>, making sure to include your operating system (e.g. Windows 10, Mac OS), your web browser (e.g. Chrome, Firefox, Opera, Internet Explorer), the output from your <a href="https://zapier.com/help/troubleshoot/behavior/view-and-save-your-browser-console-logs" target="_blank" rel="noopener">web browser's Console</a>, and any additional details that might help us to resolve the issue.
                    </p>
                </div>
            </details>

            <details class="card mb-3">
                <summary class="card-header">@lang('Why is an email address needed to create an account?')</summary>

                <div class="card-body">
                    <p>
                        Accounts with confirmed email addresses are only required to create Queues, not to join existing Queues.
                    </p>
                    <p>
                        We require a confirmed email address in order to prevent abuse from bots/spam and to provide a mechanism for you to reset your password if needed. We don't share your email address with advertisers or use it marketing or any other purpose.
                    </p>
                    <p>
                        If you are uncomfortable with providing your email address and don't care about account recovery, feel free to use a temporary email service to sign up for an account.
                    </p>
                </div>
            </details>

            <details class="card mb-3">
                <summary class="card-header">@lang('Is there a way to search for open Queues?')</summary>

                <div class="card-body">
                    <p>
                        We do not currently provide a mechanism to list or search open Queues. In order to join a Queue you will need to receive an invite link from another source.
                    </p>
                </div>
            </details>

            <details class="card mb-3">
                <summary class="card-header">@lang('I\'m hosting a queue and people aren\'t moving from "In queue" to "Has code"; why?')</summary>

                <div class="card-body">
                    <p>
                        A person's status is updated to "Has code" when they are shown the code. If they have reached the end of the Queue and their status isn't updated within a few seconds, it's most likely because they have closed the window/tab that had the Queue open or their web browser has JavaScript disabled.
                    </p>
                    <p>
                        If you have a way to contact them (e.g. via their Reddit username if you chose to ask for it when creating the Queue) then you can send them a message to confirm whether they are still interested in visiting your island. If not then you have the option to remove them from the Queue as needed.
                    </p>
                </div>
            </details>

            <details class="card mb-3">
                <summary class="card-header">@lang('I have additional questions or have encountered an issue, how can I contact you?')</summary>

                <div class="card-body">
                    <p>
                        If you have discovered an issue with the website or have a feature suggestion, please <a href="https://github.com/mschlachter/turnip-queue/issues" target="_blank" rel="noopener">submit an issue on GitHub</a> if possible. For all other inquiries, or if you are unable to submit through GitHub, please fill out our <a href="{{ route('info.contact') }}">contact form</a>.
                    </p>
                </div>
            </details>
        </div>
    </div>
</div>
@endsection
