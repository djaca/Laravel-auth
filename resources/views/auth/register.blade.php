@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Register</div>
            <div class="panel-body">

                {!! Form::open(['route' => 'register', 'method' => 'post', 'class' => 'form-horizontal']) !!}

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    {!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::text('name', old('email'), ['class' => 'form-control', 'autofocus']) !!}
                        @include('auth.partials.inputError', ['input' => 'name'])
                    </div>
                </div>

                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', 'E-Mail Address', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                        @include('auth.partials.inputError', ['input' => 'email'])
                    </div>
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                        @include('auth.partials.inputError', ['input' => 'password'])
                    </div>
                </div>

                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    {!! Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-md-4 control-label']) !!}
                    <div class="col-md-6">
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        @include('auth.partials.inputError', ['input' => 'password_confirmation'])
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-user"></i> Register
                        </button>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
