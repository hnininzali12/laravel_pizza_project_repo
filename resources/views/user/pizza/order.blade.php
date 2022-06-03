@extends('user.layout.app')
@section('content')
<div class="row mt-5 d-flex justify-content-center">
    <div class="col-4 ">
        <img src="{{asset('uploads/'.$pizza->image)}}" id="orderImage" class="img-thumbnail" width="100%"><br>
        <a href="{{ route('user#index') }}">
            <button class="btn bg-dark text-white" style="margin-top: 20px;">
                <i class="fas fa-backspace"></i> Back
            </button>
        </a>
       <div class="mt-5">
           <span class="text-danger fs-3">Total Price-</span>
           <span class="text-success fs-3"> {{Session::get('totalPrice')}}kyats</span>
       </div>
    </div>
    <div class="col-6 mb-5">
        @if (Session::has('totalTime'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <p>Order success!Waiting for  {{Session::get('totalTime')}} mins</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
       <h5>Name:</h5>
       <span>{{$pizza->pizza_name}}</span><hr>
       <h5>Price:</h5>
       <span>{{$pizza->price-$pizza->discount_price}}</span> kyats<hr>
       <h5>Waiting Time:</h5>
       <span>{{$pizza->waiting_time}}</span> mins <hr>
       <form action="{{route('user#placeOrder')}}" method="post">
           @csrf
           <div class="mb-3">
            <h5>Pizza Count:</h5>
            <input type="number" name="pizzaCount" id="" class="form-control">
           </div>
           @if($errors->has('pizzaCount'))
           <p class="text-danger">{{$errors->first('pizzaCount')}}</p>
           @endif
           <h5>Payment:</h5>
           <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment" id="inlineRadio1" value="1">
            <label class="form-check-label" for="inlineRadio1">Credit card</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="payment" id="inlineRadio2" value="2">
            <label class="form-check-label" for="inlineRadio2">Cash</label>
          </div>
          @if($errors->has('payment'))
          <p class="text-danger">{{$errors->first('payment')}}</p>
          @endif
          <hr>
          <span class="text-success"></span><hr>
          <button class="btn btn-danger float-end mt-2 col-12" type="submit"><i class="fas fa-shopping-cart"></i> Place Order</button>
       </form>
    </div>
</div>
@endsection
