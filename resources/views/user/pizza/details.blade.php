@extends('user.layout.app')
@section('content')
<div class="row mt-5 d-flex justify-content-center">

    <div class="col-4 ">
        <img src="{{asset('uploads/'.$pizza->image)}}" id="orderImage"class="img-thumbnail" width="100%">            <br>
        <a href="{{route('user#pizzaOrder')}}">  <button class="btn btn-primary float-end mt-2 col-12"><i class="fas fa-shopping-cart"></i> Order</button></a>
        <a href="{{ route('user#index') }}">
            <button class="btn bg-dark text-white" style="margin-top: 20px;">
                <i class="fas fa-backspace"></i> Back
            </button>
        </a>
    </div>
    <div class="col-6 mb-5">
       <h4>Name:</h4>
       <span>{{$pizza->pizza_name}}</span><hr>
       <h4>Price:</h4>
       <span>{{$pizza->price}}</span> kyats<hr>
       <h4>Discount price:</h4>
       <span>{{$pizza->discount_price}}</span> kyats<hr>
       <h4>Buy One Get One:</h4>
       <span>
       @if ($pizza->buy_one_get_one ==0)
           Not Have
       @else
           Have
       @endif
       </span><hr>
       <h4>Waiting Time:</h4>
       <span>{{$pizza->waiting_time}}</span> mins<hr>
       <h4>Description:</h4>
       <span>{{$pizza->description}}</span><hr>
       <h3 class="text-danger">Total</h3>
       <span class="text-success">{{$pizza->price-$pizza->discount_price}}</span><hr>
    </div>
</div>
@endsection
