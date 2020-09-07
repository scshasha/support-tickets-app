@component('mail::message')
Hello {{ ucfirst($contactName) }},<br><br>

<p>
Your ticket has been created with a reference number #{{ $ticketId }} for future communication regarding this ticket<br />
An agent will be assigned to assist your with the matter as soon as possible. Below is a summary of your ticket details. You may login on our platform to track the tickets progress.
</p>
--- 
<p>
Title<: {{ $ticketTitle }}<br>
Status<: {{ $ticketStatus }}<br>
Priority<: {{ $ticketPriority }}<br>
</p>

@component('mail::button', ['url' => $ticketUri])
{{ $ticketUrlText }}
@endcomponent

Take care,<br>
---<br><br>
{{ config('app.name') }} team
@endcomponent