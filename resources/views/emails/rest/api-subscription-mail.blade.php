@component('mail::message')
# Dear API customer {{ $user->getName() }}

Your API access request was accepted and here's your api token
for use in subsequents requests.

#API TOKEN : {{ $token }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
