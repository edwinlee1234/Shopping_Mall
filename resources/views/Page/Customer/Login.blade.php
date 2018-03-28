@extends('Page/Customer/App')

@section('title', $title)

@section('content')
    <div id="LogIn">
      {{ Form::open(array('url' => 'user/auth/sign-in', 'method' => 'post')) }}
        {{ Form::token() }}
          <div class="form-group">
            <label for="Email">Email</label>
            @if ($errors->has('email'))
                <input type="email" class="form-control is-invalid" name="email" placeholder="Email" value="{{ old('email') }}">
                <div class="invalid-feedback">
                  {{  $errors->first('email', ':message') }}
                </div>
            @else
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
            @endif
          </div>
          <div class="form-group">
            <label for="Password">Password</label>
            @if ($errors->has('password'))
                <input type="password" class="form-control is-invalid" name="password" placeholder="Password">
                <div class="invalid-feedback">
                  {{  $errors->first('password', ':message') }}
                </div>            
            @else
                <input type="password" class="form-control" name="password" placeholder="Password">
            @endif
          </div>
          {{--<div class="form-check">--}}
            {{--<input type="checkbox" class="form-check-input" id="checkbox">--}}
            {{--<label class="form-check-label" for="checkbox">Check me out</label>--}}
          {{--</div>--}}
          <br>
          <button type="submit" class="btn btn-primary">Submit</button>
        {{ Form::close() }}
    </div>
@endsection
