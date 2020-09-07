@extends('layouts.app')

@section('title', 'New Ticket')

@section('content')
    <div class="container">
        <div class="row">
        <!-- col-md-6 m-auto -->
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default mt-5">
                    <div class="panel-heading muted">Open a new support ticket</div>
                    <div class="panel-body">
                        @if (session('status'))
                            @include('includes.alert.alert-success')
                        @endif
                        <form action="{{ url('/ticket/create') }}" method="post" role="form">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('title') ?  ' has-error':'' }}">
                                <div class="col">
                                    <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control" placeholder="Title" required />
                                    @if ($errors->has('title'))
                                        <span class="help-block text-danger bg-danger">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('category') ?  ' has-error':'' }}">
                                <div class="col">
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category'))
                                        <span class="help-block text-danger bg-danger">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('priority') ?  ' has-error':'' }}">
                                <div class="col">
                                    <select name="priority" id="priority" class="form-control" required>
                                        <option value="">Select Priority</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                    @if ($errors->has('priority'))
                                        <span class="help-block text-danger bg-danger">
                                            <strong>{{ $errors->first('priority') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('message') ?  ' has-error':'' }}">
                                <div class="col">
                                    <textarea name="message" id="message" rows="5" class="form-control" placeholder="Message" required></textarea>
                                    @if ($errors->has('message'))
                                        <span class="help-block text-danger bg-danger">
                                            <strong>{{ $errors->first('message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">

                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-sm pull-right">
                                        Create
                                    </button>
                                    <button type="reset" class="btn btn-link pull-right">
                                        Clear
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection