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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
        $tickets = Ticket::paginate(2);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tickets.create', [
            'categories' => Category::all()->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mailers\AppMailer    $mailer
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request, AppMailer $mailer) // No longer using AppMailer::class
    public function store(Request $request)
    {
        $input = [];
        $this->validate($request, [
            'title'     => 'required',
            'category'  =>  'required',
            'message'   =>  'required',
            'priority'  =>  'required',
        ]);

        $input = [
            'title'         =>  $request->input('title'),
            'user_id'       =>  Auth::user()->id,
            'ticket_id'     =>  strtoupper(str_random(10)),
            'category_id'   =>  $request->input('category'),
            'priority'      =>  $request->input('priority'),
            'message'       =>  $request->input('message'),
            'status'        =>  "Open",
        ];

        // dd($input);

        $ticket = new Ticket($input);

        $ticket->save();

        // $mailer->sendTicketInformation(Auth::user(), $ticket);

        Mail::to(
            Auth::user()->email
        )->send(new TicketCreatedMail(Auth::user(), $ticket));

        return redirect()->back()->with(
            "status", "A ticket with ID: #$ticket->ticket_id has been opened."
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
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



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
