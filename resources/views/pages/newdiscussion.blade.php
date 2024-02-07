@extends('layouts.app')


@section('content')
<div class="container">
<h1>New Disscussion</h1>

<h2>here you will create new discussions</h2>


 {{-- Discussion template   --}}
    
 <form action="/new_discussion" method="POST">
    <div class="form-group">
        @csrf
      <label for="exampleInputEmail1">Title</label>
      <input type="text" class="form-control" name="title" >
      <span class="text-danger">@error('email'){{ $message }} @enderror</span>

    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Description</label>
      <input type="text" class="form-control" name="description">
      <span class="text-danger">@error('password'){{ $message }} @enderror</span>
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Brief</label>
      <input type="text" class="form-control" name="brief">
      <span class="text-danger">@error('password'){{ $message }} @enderror</span>
    </div>
   
    <button type="submit" class="btn btn-primary">{{__('profile.Submit')}}</button>
  </form>

</div> 
@endsection