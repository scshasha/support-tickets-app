@extends('layouts.app')

@section('title', $ticket->title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default mt-5">
                    <div class="panel-heading muted">
                        <span class="btn" style="cursor: default;">#{{ $ticket->ticket_id }} ({{ $ticket->title }})</span>
                        
                        <span class="pull-right">
                            <a class="btn text-info" href="@if (Auth::user()->is_admin) {{ '/admin/tickets' }}@else{{ '/tickets' }}@endif"><i class="fa fa-ticket"></i> Ticket listing</a> 
                            <a class="btn text-primary" href="{{ url('ticket/create') }}"><i class="fa fa-plus"></i> New ticket</a>
                            @if (Auth::user()->is_admin)
                                <a class="btn text-success js-post-action-link" href="{{ url('admin/tickets/close/'.$ticket->ticket_id) }}"><i class="fa fa-check"></i> Mark as resolved</a>
                            @endif
                        </span>
                        @if (Auth::user()->is_admin)
                            <form action="{{ url('admin/tickets/close/'.$ticket->ticket_id) }}" method="POST" id="frmResolveTicket">
                                {!! csrf_field() !!}
                            </form>
                        @endif
                    </div>
                    <div class="panel-body">

                        @if (session('status'))
                            @include('includes.alert.alert-success')
                        @endif

                        <div class="ticket-info">
                            {{-- <blockquote> --}}

                                <p>{{ $ticket->message }}</p>

                                    {{-- <small><a href="#">{{ $ticket->user->name }}</a></small>  --}}

                            {{-- </blockquote> --}}
                            <hr>
                            Priority: {{ $ticket->priority }}
                            <br>
                            Category: {{ $category->name }}
                            <br>
                            Status: <span class="label @if ($ticket->status === 'Open') {{ 'label-success' }}@else{{ 'label-danger' }}@endif">{{ $ticket->status }}</span>
                            <br>
                            Created On: {{ $ticket->created_at->diffForHumans() }}
                            <br>
                            @if(Auth::user()->is_admin && (Auth::user()->id !== $ticket->user->user_id))
                            Created By: <a href="#" style="text-decoration: underline; color: rgba(0,0,0,0.6);">{{ ucfirst($ticket->user->name) }}</a>
                            <br>
                            Account Type: @if ($ticket->user->is_admin) {{ 'Administrator' }}@else{{ 'Standard member' }}@endif
                            <br>
                            @endif
                            
                            <div class="clear clear-both" style="margin-top: 45px; margin-bottom: 45px; width: 100%; padding: 15px;"></div>
                        </div>
                        @if (!$comments->isEmpty())
                        <div id="comments" class="comments nano-content pad-all">
                            <h4>Comments</h4>
                            <hr>
                            @foreach ($comments as $comment)
                            <ul class="list-unstyled media-block">
                                <li class="mar-btm">
                                    <div class="@if($ticket->user_id === $comment->user_id) {{'media-left'}}@else{{'media-right'}}@endif">
                                        <img src="@if ($comment->user_id < 4) {{ url('img/av'.$comment->user_id.'.png') }}@else{{ url('img/user.png') }}@endif" alt="{{ $comment->user->name }}" class="img-responsive img-circle img-sm" />
                                    </div>
                                    <div class="media-body pad-hor @if($ticket->user_id === $comment->user_id) {{'speech-left'}}@else{{'speech-right'}}@endif">
                                        <div class="speech">
                                            <a href="#" class="media-heading">{{ ucfirst($comment->user->name) }}</a>
                                            <span class="media-meta speech-time"><small>{{ $comment->created_at->diffForHumans() }}</small></span>
                                            <p>
                                                {{ $comment->comment }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            @endforeach
                        </div>
                        @endif
                        <div class="comment-form">
                            <form class="form" method="POST" action="{{ url('/comment') }}">
                                {!! csrf_field() !!}
                                <h4>Post Comment</h4>
                                <hr>
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                    <textarea name="comment" id="comment" rows="5" class="form-control" @if($ticket->status === "Closed") {{ 'disabled' }}@endif></textarea>
                                    @if ($errors->has('comment'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('comment') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm pull-right" @if($ticket->status === "Closed") {{ 'disabled' }}@endif>Comment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection