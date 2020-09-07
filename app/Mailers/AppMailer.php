<?php
namespace App\Mailers;

use Illuminate\Contracts\Mail\Mailer; 
use App\Ticket;

class AppMailer 
{
    protected $senderMail = "support@helpdesk.io";//env(APP_MAILER_SENDER_MAIL);
    protected $senderName = "Support Ticket";//env(APP_MAILER_SENDER_NAME);
    protected $to;
    protected $subject;
    protected $view;
    protected $mailer;
    protected $data = array();

    /**
     * @param object $user
     * @param App\Ticket $ticket
     */
    public function sendTicketInformation($user, Ticket $ticket) {
        $this->to = $user->email;
        $this->subject = "[Ticket ID: $ticket->ticket_id] $ticket->title";
        $this->view = 'emails.ticket-info';
        $this->data = compact('user', 'ticket');

        return $this->deliver();
    }

    public function sendNewUserAccountMail($user, array $data) {
        $this->to = $user->email;
        $this->subject = sprintf('%s: %s', strtoupper(env('APP_ENV')), "Account Created!");
        $this->view('emails.account-created-notification');
        $this->data = array(
            'name' => $data['name'],
            'usermane' => $data['email'],
            'password' => $data['password'],
            'hyperlink' => $data['url']
        );

        return $this->deliver();
    }


    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    /**
     * @return void
     */
    protected function deliver() {
        $this->mailer->send($this->view, $this->data, function($message) {
            $message->from($this->senderMail, $this->senderName)->to($this->to, $this->subject);
        });
    }
    

}