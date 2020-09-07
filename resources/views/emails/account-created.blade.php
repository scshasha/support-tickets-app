@component('mail::message')

<p>Welcome {{ ucfirst($contactName) }},</p><br>

<p>Your user account has been created. Below are the login details you have created:</p>
<hr>
<div style="box-sizing: border-box;font-size: 13px;border: 1px dotted #74787e;border-radius: 3px;padding: 10px 10px;letter-spacing: 1px;">
<strong>Username:</strong>: {{ $loginUsername }}<br />
<strong>Password:</strong>: {{ $loginPassword }}

@component('mail::button', ['url' => $loginUri])
{{ $loginUrlText }}
@endcomponent
</div>




Take care,<br>

---<br><br>

{{ config('app.name') }} team
@endcomponent