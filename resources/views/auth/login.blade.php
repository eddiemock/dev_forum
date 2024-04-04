@extends('layouts.app')


@section('content')
    <div class="container">
        <h1>{{ __('profile.Login') }}</h1>

        <form action="/login" method="POST">
            <div class="form-group">
                @csrf
                <label for="name">{{ __('profile.Username') }}</label>
                <input type="text" class="form-control" name="name" aria-describedby="nameHelp" placeholder="Enter name">
                <span class="text-danger">@error('name'){{ $message }} @enderror</span>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">{{ __('profile.Password') }}</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
                <span class="text-danger">@error('password'){{ $message }} @enderror</span>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('profile.Submit') }}</button>

            <div class="form-group">
                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
            </div>
        </form>


    </div>
@endsection
