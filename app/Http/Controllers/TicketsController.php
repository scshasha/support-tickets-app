<?php

namespace App\Http\Controllers;

use App\User;
use App\Ticket;
use App\Category;
use App\Mail\TicketStatusMail;
use App\Mail\TicketCreatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketsController extends Controller
{


    public function __construct()
    {
        // $this->middleware('auth'); Need to allow non-registered users to make and view thier tickets.
    }

    public function index()
    {
        
        $tickets = Ticket::paginate(5);
        $categories = Category::all();
        
        if (Auth::user()) {
            if (Auth::user()->is_admin === 1) {
                return view('admin.tickets', compact('tickets', 'categories'));
            } elseif(Auth::user()->is_admin === 2) {
                // @TODO: Create agent view.
                return view('agent.tickets');
            }
        }

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
        $a = User::all()->where('is_admin', 1);

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
        Mail::to(implode(';', $to))->send(new TicketCreatedMail(Auth::user(), $ticket));

        // Response message.
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

        if (Auth::user() && Auth::user()->is_admin === 1) {
            return view('admin.ticket-details', $viewData);
        } else if (Auth::user() && Auth::user_admin === 2) {
            // Agent view.
            redirect('/assigned/tickets'); // @TODO: Create view
        }

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


    // public function edit(Ticket $ticket)
    public function edit($ticket_id)
    {
        /**
         * To edit user ned to be logged in and HAS to be an administrator.
         */
        if (Auth::user() && Auth::user()->is_admin === 1) {
            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            $agents = User::all()->where('is_admin', 2);
            $category = $ticket->category;
    
            return view('admin.ticket-edit', compact('ticket', 'category', 'agents')); // @TODO: Create View.
        }

        return redirect()->back()->with("error", "You are not authorized to perform this action.");
        
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (Auh::user() && Auth::user()->is_admin) {
            $this->validate($request, [
                'title'     => 'required',
                'message'  =>  'required',
                'priority'  =>  'required',
                'status'  =>  'required',
                'category_id'  =>  'required',
            ]);

            $input = [
                'title'         =>  $request->input('title'),
                'message'       =>  $request->input('message'),
                'category_id'   =>  $request->input('category_id'),
                'priority'      =>  $request->input('priority'),
                'status'        =>  $request->input('status'),
                'user_id'        =>  !empty($request->input('user_id')) ? $request->input('user_id') : null,
            ];

            // Check if we should notify agent.
            if (!empty($input['user_id'])) {
                if ($ticket->user_id !== $input['user_id']) {
                    // Send notification.
                }
            }

            $ticket->title = $input['title'];
            $ticket->message = $input['message'];
            $ticket->category_id = $input['category_id'];
            $ticket->priority = $input['priority'];
            $ticket->status = $input['status'];
            
            $ticket->save();

            return redirect()->back()->with('status', 'Ticket has been updated');
        }
    }

    public function destroy(Ticket $ticket)
    {
        //
    }


}
