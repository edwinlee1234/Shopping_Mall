@extends('Page/Customer/App')

@section('title', $title)

@section('content')
<h1>Contact:</h1>
<form>
  <div class="form-group">
    <label>Title</label>
    <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter Title">
  </div>
  <div class="form-group">
    <label>Content</label>
    <textarea rows="6" class="form-control" placeholder="Enter Content"></textarea>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection

@section('script')
@parent
@endsection