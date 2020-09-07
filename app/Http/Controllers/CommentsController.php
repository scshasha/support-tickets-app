<?php

namespace App\Http\Controllers;

use App\User;
use App\Ticket;
use App\Comment;
use App\Mail\TicketCommentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeComment(Request $request)
    {
        //
        $this->validate($request, [
            'comment' => 'required'
        ]);

        $comment = Comment::create([
            'comment' => $request->input('comment'),
            'ticket_id' => $request->input('ticket_id'),
            'user_id' => Auth::user()->id,
        ]);

        if ($comment->ticket->user_id !== Auth::user()->id) {
            $ticketOwner = User::where('id', $comment->ticket->user_id)->firstOrFail();
            $commentingUser = Auth::user();

            // Send E-mail
            Mail::to(
                $ticketOwner->email
            )->send(new TicketCommentMail($commentingUser, $comment->ticket, $comment));
        }

        return redirect()->back()->with(
            "status", "Comment submitted."
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
