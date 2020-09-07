<?php

namespace App\Mail;

use App\User;
use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Ticket $ticket)
    {

        $this->subject("$ticket->tile (Ticket ID: $ticket->ticket_id)");

        $this->data = [
            'contactName' => $user->name,
            'ticketTitle' => $ticket->title,
            'ticketStatus' => $ticket->status,
            'ticketPriority' => $ticket->priority,
            'ticketId' => $ticket->ticket_id,
            'ticketUri' => sprintf('%s/tickets/%s', env('APP_URL'), $ticket->ticket_id),
            'ticketUrlText' => "click here to view ticket on our online platform"
        ];
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ticket-created')->with($this->data);
    }
}
