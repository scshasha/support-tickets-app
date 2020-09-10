<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Category;
// use App\Mailers\AppMailer;
use App\Mail\TicketStatusMail;
use App\Mail\TicketCreatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
{


    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin === 1) {
            // load all tickets in admin view.
            // return view('admin.tickets');
        } elseif($user->is_admin === 2) {
            // load tickets assigned to agent
            // return view('agent.tickets');
        }

        $tickets = Ticket::paginate(5);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }


    public function create()
    {
        return view('tickets.create', [
            'categories' => Category::all()->all()
        ]);
    }


    
    // public function store(Request $request, AppMailer $mailer) // No longer using AppMailer::class
    public function store(Request $request)
    {
        $to = $input = [];

        // Get Administrator E-mails to Notify
        $a = \App\User::all()->where('is_admin', 1);

        foreach($a as $b) {
            $to[] = $b->email;
        }
        
        // Validate Input
        $this->validate($request, [
            'title'     => 'required',
            'author_name'  =>  'required',
            'author_email'   =>  'required|email',
            'message'  =>  'required',
        ]);
        
        $input = [
            'title'         =>  $request->input('title'),
            'ticket_id'     =>  strtoupper(str_random(15)),
            'message'       =>  $request->input('message'),
            'author_name'   =>  $request->input('author_name'),
            'author_email'  =>  $request->input('author_email'),
            'category_id'   =>  Category::where('name', 'Uncategorized')->firstOrFail()->id,
            'priority'      =>  'low',
            'status'        =>  "Open",
        ];
        // Ticket::create($input);

        $ticket = new Ticket($input);
        $ticket->save();

        // Notify Admin of the new ticket
        // Mail::to(implode(';', $to))->send(new TicketCreatedMail(Auth::user(), $ticket));

        // Return reply response
        $responseMessage = sprintf('Your ticket is submitted, we will be in touch. You can view the ticket status <a href="%s/tickets/%s">here</a>.', env('APP_URL'), $ticket->ticket_id);

        return redirect()->back()->with("status", $responseMessage);
    }


    // public function show(Ticket $ticket, $ticket_id)
    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $category = $ticket->category;
        $comments = $ticket->comments;
        $viewData = compact('ticket', 'category', 'comments');

        // dd($comments);

        return view('tickets.single', $viewData);
    }

    public function showByCurrentUser() {

        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();
        $viewData = compact('tickets', 'categories');

        return view('tickets.list-user', $viewData);
    }

    public function close($ticket_id) {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $ticket->status = 'Closed';
        $ticket->save();
        $ticketOwner = $ticket->user;

        Mail::to(
            $ticketOwner->email
        )->send(new TicketStatusMail($ticket, $ticketOwner));

        return redirect()->back()->with("status", "Ticket closed.");

    }


    public function edit(Ticket $ticket)
    {
        //
    }

    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    public function destroy(Ticket $ticket)
    {
        //
    }


}
