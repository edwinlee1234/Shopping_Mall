@extends('Page/Customer/App')

@section('title', $title)

@section('content')
    <div id="checkout">
        <h1>Checkout</h1>
        {{ Form::open(array('url' => 'cart/checkoutProcess', 'method' => 'post')) }}
        {{ Form::token() }}
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>Full Name</label>
                    @if ($errors->has('name'))
                        <input name="name" type="text" class="form-control is-invalid" placeholder=" Name" value="{{ old('name') }}">
                        <div class="invalid-feedback">
                            {{  $errors->first('name', ':message') }}
                        </div>
                    @else
                        <input name="name" type="text" class="form-control" placeholder="Name" value="{{  $userInfo->name  }}">
                    @endif
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Phone Number</label>
                    @if ($errors->has('phoneNumber'))
                        <input name="phoneNumber" type="text" class="form-control is-invalid" placeholder="Phone Number" value="{{ old('phoneNumber') }}">
                        <div class="invalid-feedback">
                            {{  $errors->first('phoneNumber', ':message') }}
                        </div>
                    @else
                        <input name="phoneNumber" type="text" class="form-control" placeholder="Phone Number" value="{{  $userInfo->phone  }}">
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label>Address</label>
                @if ($errors->has('address'))
                    <input name="address" type="text" class="form-control is-invalid" placeholder="Address" value="{{ old('address') }}">
                    <div class="invalid-feedback">
                        {{  $errors->first('address', ':message') }}
                    </div>
                @else
                    <input name="address" type="text" class="form-control" placeholder="Address" value="{{ $userInfo->address }}">
                @endif
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Payment</label>
                    <select name="payment" class="form-control">
                        <option value="ATM">ATM</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        {{ Form::close() }}
    </div>
@endsection

@section('script')
    @parent
@endsection