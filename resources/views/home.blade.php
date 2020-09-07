@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        @include('includes.alert.alert-success')
                    @endif

                    @if(Auth::user()->is_admin)
                        <!-- load admin widgets -->
                        <p>See all <a href="{{ url('admin/tickets') }}">tickets</a></p>
                    @else
                        <p>See all your <a href="{{ url('tickets') }}">tickets</a> or <a href="{{ url('ticket/create') }}">open a new ticket</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
