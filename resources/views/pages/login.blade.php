@extends('layouts.app')


@section('content')
    <div class="container">
        <h1>{{ __('profile.Login') }}</h1>

        <form action="/login" method="POST">
            <div class="form-group">
                @csrf
                <label for="exampleInputEmail1">{{ __('profile.Email address') }}</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp"
                    placeholder="Enter email">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">{{ __('profile.Password') }}</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
                <span class="text-danger">@error('password'){{ $message }} @enderror</span>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('profile.Submit') }}</button>
        </form>

    </div>
@endsection
