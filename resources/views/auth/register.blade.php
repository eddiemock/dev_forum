@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('profile.Register') }}</h1>

        <form action="/register" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('profile.Username') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                <span class="text-danger">@error('name'){{ $message }} @enderror</span>
            </div>

            <div class="form-group">
                <label for="email">{{ __('profile.Email address') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
            </div>

            <div class="form-group">
                <label for="password">{{ __('profile.Password') }}</label>
                <input type="password" class="form-control" id="password" name="password">
                <span class="text-danger">@error('password'){{ $message }} @enderror</span>
            </div>

            <div class="form-group">
                <label for="password_confirmation">{{ __('profile.Confirm Password') }}</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                <span class="text-danger">@error('password_confirmation'){{ $message }} @enderror</span>
            </div>

            <div class="form-group">
                <label for="country">{{ __('profile.Country') }}</label>
                <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                <span class="text-danger">@error('country'){{ $message }} @enderror</span>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('profile.Submit') }}</button>
        </form>
    </div>
@endsection
