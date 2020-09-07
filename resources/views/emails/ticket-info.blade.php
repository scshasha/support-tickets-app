<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suppor Ticket Information</title>
</head>
<style>
    body {
        font-family: 'Raleway'
    }
</style>
<body>
    <p>
        Thank you {{ ucfirst($user->name) }} for contacting our support team. A support ticket has been opened for you.<br>
        You will be notified when a response is made by email. <br><br>
        The details of your ticket are shown below:
    </p>
    <table>
        <tr>
            <td>Title</td>
            <td>{{ $ticket->title }}</td>
        </tr>
        <tr>
            <td>Priority</td>
            <td>{{ $ticket->priority }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $ticket->status }}</td>
        </tr>
    </table>
    <p>
        You can view the ticket at any time at <a href="{{ url('ticket/detail/'. $ticket->ticket_id) }}">{{ url('ticket/detail/'. $ticket->ticket_id) }}</a>
    </p>

    <p>Take care,</p>
    <p>--</p>
    <p>{{ config('app.name') }} team</p>
</body>
</html>