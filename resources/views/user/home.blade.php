@extends('user.layout.app')
@section('content')
<div class="container header px-4 px-lg-5" id="home">
    <!-- Heading Row-->
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" id="code-lab-pizza" src="https://www.pizzamarumyanmar.com/wp-content/uploads/2019/04/chigago.jpg" alt="..." /></div>
        <div class="col-lg-5" id="about">
            <h1 class="font-weight-light" >CODE LAB Pizza</h1>
            <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
            <a class="btn btn-primary" href="#!">Enjoy!</a>
        </div>
    </div>

    <!-- Content Row-->
    <div class="d-flex main-container">
        <div class="searchItems">
            <div class="col-3 me-5">
                <div class="searchBox">
                    <div class="py-5 text-center">
                        <form class="d-flex m-5" action="{{route('user#searchPizzaItem')}}" method="get">
                            @csrf
                            <input class="form-control me-2" name="searchData" value="{{old('searchData')}}" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>

                        <div >
                            <a href="{{route('user#index')}}" class="text-decoration-none text-black"><div class="m-2 p-2 searchText">All</div></a>
                            @foreach ($category as $item)
                            <a href="{{route('user#pizzaSearch',$item->category_id)}}" class="text-decoration-none text-black "><div class="m-2 p-2 searchText">{{$item->category_name}}</div></a>
                            @endforeach
                        </div>
                        <hr>
                        <form action="{{route('user#searchItem')}}" method="get">
                        @csrf
                        <div class="text-center m-4 p-2">
                            <h3 class="mb-3">Start Date - End Date</h3>
                                <input type="date" name="startDate" id="" class="form-control"> -
                                <input type="date" name="endDate" id="" class="form-control">
                        </div>
                        <hr>
                        <div class="text-center m-4 p-2">
                            <h3 class="mb-3">Min - Max Amount</h3>
                                <input type="number" name="minPrice" id="" class="form-control" placeholder="minimum price"> -
                                <input type="number" name="maxPrice" id="" class="form-control" placeholder="maximun price">
                        </div>
                        <button type="submit" class="btn btn-dark "> Search  <i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
            <div class="mt-3 ">
                @if ($status==1)
                <div class="row pizzaItems " id="pizza">
                  @if (count($pizza) ==2)
                  @foreach ($pizza as $item)
                  <div class="col-xxl-6 mb-5 " >
                     <div class="card h-100 " id="pizzaBox" style="width: 100px">
                         <!-- Sale badge-->
                        @if ($item->buy_one_get_one_status != 1)
                        <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Buy One Get One</div>
                        @endif
                         <!-- Product image-->
                         <img class="card-img-top image" src="{{asset('uploads/'.$item->image)}}" style="height: 100px" />
                         <!-- Product details-->
                         <div class="card-body p-4">
                             <div class="text-center">
                                 <!-- Product name-->
                                 <h5 class="fw-bolder">{{$item->pizza_name}}</h5>
                                 <!-- Product price-->
                                 <span class="text-dark">{{$item->price}} kyats</span>
                             </div>
                         </div>
                         <!-- Product actions-->
                         <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                             <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('user#pizzaDetails',$item->pizza_id) }}">More Detail</a></div>
                         </div>
                     </div>
                 </div>
                  @endforeach
                  @else
                  @foreach ($pizza as $item)
                  <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-5 col-sm-10 col-xs-10  mb-4">
                     <div class="card h-100" id="pizzaBox"style="width: 250px">
                         <!-- Sale badge-->
                        @if ($item->buy_one_get_one_status != 1)
                        <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Buy One Get One</div>
                        @endif
                         <!-- Product image-->
                         <img class="card-img-top"  src="{{asset('uploads/'.$item->image)}}" style="height: 150px" />
                         <!-- Product details-->
                         <div class="card-body p-4">
                             <div class="text-center">
                                 <!-- Product name-->
                                 <h5 class="fw-bolder">{{$item->pizza_name}}</h5>
                                 <!-- Product price-->
                                 <span class="text-dark">{{$item->price}} kyats</span>
                             </div>
                         </div>
                         <!-- Product actions-->
                         <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                             <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('user#pizzaDetails',$item->pizza_id) }}">More Detail</a></div>
                         </div>
                     </div>
                 </div>
                  @endforeach
                 @endif
                </div>
                @else
                <div class="alert alert-danger mt-4" style="width: 700px" role="alert">
                    <p class="text-center">There is no pizza!</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="text-center d-flex justify-content-center align-items-center" id="contact">
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-8 col-xs-8 border shadow-sm ps-5 pt-5 pe-5 pb-2 mb-5" >
        @if (Session::has('sendSuccess'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{Session::get('sendSuccess')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        <h3>Contact Us</h3>

        <form action="{{route('user#createContact')}}" method="post" class="my-4">
            @csrf
            <input type="text" name="name" class="form-control my-3" placeholder="Name">
            @if($errors->has('name'))
            <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
            <input type="text" name="email" class="form-control my-3" placeholder="Email">
            @if($errors->has('email'))
            <p class="text-danger">{{$errors->first('email')}}</p>
            @endif
            <textarea class="form-control my-3" name="message" id="exampleFormControlTextarea1" rows="3" placeholder="Message"></textarea>
            @if($errors->has('message'))
            <p class="text-danger">{{$errors->first('message')}}</p>
            @endif
            <button type="submit" class="btn btn-outline-dark">Send  <i class="fas fa-arrow-right"></i></button>
        </form>
    </div>
</div>

@endsection
