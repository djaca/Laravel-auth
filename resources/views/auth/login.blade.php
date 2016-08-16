@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Login</div>
            <div class="panel-body">

                {!! Form::open(['route' => 'login', 'method' => 'post', 'class' => 'form-horizontal']) !!}

                	<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email', 'E-Mail Address', ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::email('email', null, ['class' => 'form-control', 'autofocus']) !!}
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

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> Login
                            </button>
                            <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                        </div>
                    </div>
                {!! Form::close() !!}

                <hr>

                <a href="{{ route('login.social', 'github') }}" class="btn btn-social btn-github">
                    <span class="fa fa-github"></span> Sign in with Github
                </a>
            </div>
        </div>
@endsection
