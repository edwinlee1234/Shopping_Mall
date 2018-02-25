@extends('Page/Admin/App')

@section('title', $title)

@section('style')
<style>
    #sideBar{
      display: none;
    }
    
    #AdminLogIn{
      padding: 20px;
      border: solid 1px rgba(0,0,0,0.1);
      border-radius: 5px;
      box-shadow: 8px, 8px, 8px, 8px;
      margin-top: 8%;
    }
</style>
@endsection

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col">
      <div id="AdminLogIn">
        <h1>Admin</h1>
        {{ Form::open(array('url' => 'user/auth/admin-sign-in', 'method' => 'post')) }}
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
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
          {{ Form::close() }}
      </div>      
    </div>
  </div>  
</div>

@endsection

@section('script')
@parent
<script type="text/javascript">

</script>
@endsection


