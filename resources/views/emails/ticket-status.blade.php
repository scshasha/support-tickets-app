@component('mail::message')
Hello {{ ucfirst($contactName) }},<br><br>

Your support ticket with ID #{{ $ticketId }} has been marked has resolved and closed.

Take care,<br>
---<br><br>
{{ config('app.name') }} team
@endcomponent