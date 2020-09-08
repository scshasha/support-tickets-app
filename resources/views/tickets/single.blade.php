@extends('layouts.app')

@section('title', $ticket->title)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default mt-5">
                    <div class="panel-heading muted">
                        <span class="btn" style="cursor: default;"><strong>#{{ $ticket->ticket_id }} ({{ $ticket->title }})</strong></span>
                        
                        <span class="pull-right">
                            <a class="btn text-dark" href="@if (Auth::user()->is_admin) {{ '/admin/tickets' }}@else{{ '/tickets' }}@endif"><i class="fa fa-ticket"></i> Ticket listing</a> 
                            <a class="btn text-dark" href="{{ url('ticket/create') }}"><i class="fa fa-plus"></i> New ticket</a>
                            @if (Auth::user()->is_admin)
                                <a class="btn text-dark js-post-action-link" href="{{ url('admin/tickets/close/'.$ticket->ticket_id) }}"><i class="fa fa-check"></i> Mark as resolved</a>
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

                        <div class="col-md-10" id="ticket-content">
                            {!! $ticket->message !!}
                            <div class="clear clear-both" style="width: 99%;padding: 15px;margin: 25px auto;"></div>
                        </div>
                        <div class="ticket-data">
                            <table class="table table-stripped table-striped">
                                <tbody>
                                    <tr>
                                        <td>Priority</td>
                                        <td>{{ ucfirst($ticket->priority) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td>{{ $category->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><span class="label @if ($ticket->status === 'Open') {{ 'label-success' }}@else{{ 'label-danger' }}@endif">{{ $ticket->status }}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Created On</td>
                                        <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @if(Auth::user()->is_admin && (Auth::user()->id !== $ticket->user->user_id))
                                    <tr>
                                        <td>Created By</td>
                                        <td><a href="#" style="text-decoration: underline; color: rgba(0,0,0,0.6);">{{ ucfirst($ticket->user->name) }}</a></td>
                                    </tr>
                                    <!-- {{-- @if ($ticket->user->is_admin) {{ 'Administrator' }}@else{{ 'Standard member' }}@endif --}} -->
                                    @endif
                                </tbody>
                            </table>
                            <div class="clear clear-both" style="width: 99%;padding: 15px;margin: 25px auto;"></div>
                        </div>
                        @if (!$comments->isEmpty())
                        <div id="comments" class="comments nano-content pad-all">
                            <h4 class="sec-title"><span>Comments&nbsp;<span class="badge badge-dark">{{ count($comments) }}</span></span></h4>
                            <!-- <hr> -->
                            @foreach ($comments as $comment)
                            <ul class="list-unstyled media-block">
                                <li class="mar-btm">
                                    <div class="@if(Auth::user()->id === $comment->user_id) {{'media-right'}}@else{{'media-left'}}@endif">
                                        <img src="@if ($comment->user_id < 4) {{ url('img/av'.$comment->user_id.'.png') }}@else{{ url('img/user.png') }}@endif" alt="{{ $comment->user->name }}" class="img-responsive img-circle img-sm" />
                                    </div>
                                    <div class="media-body pad-hor @if(Auth::user()->id === $comment->user_id) {{'speech-right'}}@else{{'speech-left'}}@endif">
                                        <div class="speech">
                                            <a href="#" class="media-heading">{{ ucfirst($comment->user->name) }}</a>
                                            <span class="media-meta speech-time"><small>{{ $comment->created_at->diffForHumans() }}</small></span>
                                            <p>
                                                {!! $comment->comment !!}
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
                                <h4 class="sec-title">
                                    <span>Post a Comment</span>
                                </h4>
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