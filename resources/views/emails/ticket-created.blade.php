@component('mail::message')
Ticket ID #{{ $ticketId }} created! 
<br>

Ticket Staus: {{ $ticketStatus }}
Ticket Priority: {{ $ticketPriority }}
<br>
<br>
View ticket progress on <a href="{{ $ticketUri }}">{{ $ticketUri }}</a>.
<br>
<br>
<br>
Take care,<br>
---<br><br>
{{ config('app.name') }} team
@endcomponent