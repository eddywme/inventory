@component('mail::message')
# Hello Mr/Ms {{ $user->first_name." ".$user->last_name}}

Your item request was approved successfully.
@component('mail::panel')
   Item Name : {{ $item->name }}  Serial Number: {{ $item->serial_number }}
@endcomponent
Thanks,<br>
{{ config('app.name') }} Support Team.
@endcomponent
