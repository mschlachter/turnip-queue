@component('mail::message')
# New Message from Turnip Queue

## Email address

@component('mail::panel')
{{ $form_email }}
@endcomponent

## Subject

@component('mail::panel')
{{ $form_subject }}
@endcomponent

## Message

@component('mail::panel')
{{ $form_message }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
