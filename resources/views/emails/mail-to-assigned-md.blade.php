@component('mail::message')
# Hello Mr/Ms {{ $user->first_name." ".$user->last_name}}

{{ $message_text  }}.



Thanks,<br>
{{ config('app.name') }} Support Team.
@endcomponent
