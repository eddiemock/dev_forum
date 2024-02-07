@extends('layouts.app')


@section('content')
<div class="container">
<h1>Edit Disscussion</h1>

<h2>here you will create new discussions</h2>

 

  {{-- Discussion template   --}}
    
 <form action="/update_post" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $discussion->id }}">
    <div class="form-group">
      <label for="exampleInputEmail1">Title</label>
      <input type="text" class="form-control" name="title" value="{{ $discussion->post_title }}" >
      <span class="text-danger">@error('email'){{ $message }} @enderror</span>

    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Description</label>
      <input type="text" class="form-control" name="description" value="{{ $discussion->description }}">
      <span class="text-danger">@error('password'){{ $message }} @enderror</span>
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Brief</label>
        <textarea name="brief"  cols="30" rows="10" class="form-control">
            {{ $discussion->brief}}
        </textarea>
      <span class="text-danger">@error('password'){{ $message }} @enderror</span>
    </div>
   
    <button type="submit" class="btn btn-primary">Update</button>
  </form> 

</div> 
@endsection