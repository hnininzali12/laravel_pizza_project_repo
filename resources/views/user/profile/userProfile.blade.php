<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pizza Order System</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{asset('customer/assets.favicon.ico')}}" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('customer/css/styles.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('customer/css/list.css')}}">
    <script src="https://kit.fontawesome.com/953e0f59ae.js" crossorigin="anonymous"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <!-- Google Fonts -->
        <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
        />

    <style>

    </style>
</head>
<body>
    <div class="content-wrapper">
        <section class="content">
          <div class="container-fluid">
            <div class="row mt-4">
              <div class="col-8 offset-3 mt-5">
                <div class="col-md-9">
                  <div class="card">
                    <div class="card-header p-2">
                      <legend class="text-center">User Profile</legend>
                    </div>
                    <div class="card-body">
                        @if (Session::has('updateSuccess'))
                        <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
                            {{Session::get('updateSuccess')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>
                        @endif
                      <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                          <form class="form-horizontal" method="post" action="{{route('user#userProfileUpdate',$user->id)}}">
                            @csrf
                            <div class="form-group row mb-2">
                              <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{old('name',$user->name)}}" id="inputName" placeholder="Name">
                                @if($errors->has('name'))
                                <p class="text-danger">{{$errors->first('name')}}</p>
                                @endif
                              </div>
                            </div>
                            </div>
                            <div class="form-group row mb-2">
                              <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                                <input type="email" class="form-control"name="email" id="inputEmail" value="{{old('email',$user->email)}}"  placeholder="Email">
                                @if($errors->has('email'))
                                <p class="text-danger">{{$errors->first('email')}}</p>
                                @endif
                              </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="inputPhone" class="col-sm-2 col-form-label" >Phone</label>
                                <div class="col-sm-10">
                                  <input type="number" class="form-control"name="phone" id="inputPhone" value="{{old('phone',$user->phone)}}"  placeholder="Phone">
                                  @if($errors->has('phone'))
                                  <p class="text-danger">{{$errors->first('phone')}}</p>
                                  @endif
                                </div>
                              </div>
                              <div class="form-group row mb-2">
                                <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" name="address" id="inputAddress"value="{{old('address',$user->address)}}"  placeholder="Address">
                                  @if($errors->has('address'))
                                  <p class="text-danger">{{$errors->first('address')}}</p>
                                  @endif
                                </div>
                              </div>

                            <div class="form-group row mb-2">
                              <div class="offset-sm-2 col-sm-10">
                                <a href="{{route('user#userChangePassword')}}">Change Password</a>
                              </div>
                            </div>
                            <div class="form-group row mb-2">
                              <div class="offset-sm-2 col-sm-10">
                                <button type="submit" class="btn bg-dark text-white">Update</button>
                              </div>
                            </div>
                          </form>
                        </div>
                        </div>
                      </div>
                    </div>
                    <a href="{{route('user#index')}}" class="text-black"><i class="fa-solid fa-arrow-left-long fs-3"></i></a><span class="fs-4 ms-1">Back</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
</body>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script src="{{asset('customer/js/scripts.js')}}"></script>
</html>
