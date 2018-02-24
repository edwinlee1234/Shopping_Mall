@extends('Page/Customer/App')

@section('title', $title)

@section('content')
    <div id="Register">
        {{ Form::open(array('url' => 'user/auth/sign-up', 'method' => 'post')) }}
          {{ Form::token() }}
          <div class="form-group">
            <label for="Email">Email</label>
            <!--<button type="button" class="btn btn-outline-info btn-sm">Check</button> -->
            @if ($errors->has('email'))
                <input type="email" class="form-control is-invalid" name="email" placeholder="Email" value="{{ old('email') }}">
                <div class="invalid-feedback">
                  {{  $errors->first('email', ':message') }}
                </div>
            @else
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                <small class="form-text text-muted">Check Email Exists</small>
            @endif
          </div>
          <div class="form-group">
            <label for="Email">Name</label>
            @if ($errors->has('name'))
                <input type="text" class="form-control is-invalid" name="name" placeholder="Name" value="{{ old('name') }}">
                <div class="invalid-feedback">
                  {{  $errors->first('name', ':message') }}
                </div>
            @else
                <input type="text" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}">
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
          <div class="form-group">
            <label for="PasswordConfirm">Confirm Password</label>
            @if ($errors->has('passwordConfirm'))
                <input type="password" class="form-control is-invalid" name="passwordConfirm" placeholder="Password">
                <div class="invalid-feedback">
                  {{  $errors->first('passwordConfirm', ':message') }}
                </div>              
            @else
                <input type="password" class="form-control" name="passwordConfirm" placeholder="Password">
            @endif
          </div>
          <div class="form-group">
            <label for="Address">Address</label>
            @if ($errors->has('address'))
                <input type="text" class="form-control is-invalid" name="address" placeholder="Address" value="{{ old('address') }}">
                <div class="invalid-feedback">
                  {{  $errors->first('address', ':message') }}
                </div>
            @else
                <input type="text" class="form-control" name="address" placeholder="Address" value="{{ old('address') }}">
            @endif
          </div>          
          <button type="submit" class="btn btn-primary">Submit</button>
        {{ Form::close() }}
    </div>
@endsection
