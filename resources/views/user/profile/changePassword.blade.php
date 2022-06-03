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
                      <legend class="text-center">Change Password</legend>
                    </div>
                    <div class="card-body">
                       @if (Session::has('passwordNotSame'))
                      <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
                          {{Session::get('passwordNotSame')}}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      @endif
                      @if (Session::has('currentPasswordError'))
                      <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
                          {{Session::get('currentPasswordError')}}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      @endif
                      @if (Session::has('passwordSame'))
                      <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
                          {{Session::get('passwordSame')}}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      @endif
                      @if (Session::has('strlenError'))
                      <div class="alert alert-danger alert-dismissible fade show mt-1" role="alert">
                          {{Session::get('strlenError')}}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      @endif
                      @if (Session::has('success'))
                      <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
                          {{Session::get('success')}}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      @endif
                      <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                          <form class="form-horizontal" method="post" action="{{route('user#updatePassword',auth()->user()->id)}}">
                            @csrf
                            <div class="form-group row mb-2 mt-3">
                                <span class="col-sm-1 mt-2 fs-5"><i class="fa-solid fa-lock"></i></span>
                              <div class="col-sm-11">
                                <input type="password" class="form-control" name="oldPassword" value="" id="inputName" placeholder="Current password">
                                @if($errors->has('oldPassword'))
                                <p class="text-danger">{{$errors->first('oldPassword')}}</p>
                                @endif
                              </div>
                            </div>
                            </div>
                            <div class="form-group row mb-2">
                                <span class="col-sm-1 mt-2 fs-5"><i class="fa-solid fa-key"></i></span>
                              <div class="col-sm-11">
                                <input type="password" class="form-control"name="newPassword" id="inputEmail" value="" placeholder="New password">
                                @if($errors->has('newPassword'))
                                <p class="text-danger">{{$errors->first('newPassword')}}</p>
                                @endif
                              </div>
                            </div>
                            <div class="form-group row mb-2">
                                <span class="col-sm-1 mt-2 fs-5"><i class="fa-solid fa-key"></i></span>
                                <div class="col-sm-11">
                                  <input type="password" class="form-control"name="confirmPassword" id="inputPhone" value="" placeholder="Re-type new password"  >
                                  @if($errors->has('confirmPassword'))
                                  <p class="text-danger">{{$errors->first('confirmPassword')}}</p>
                                  @endif
                                </div>
                              </div>
                            <div class="form-group row mb-2">
                              <div class="offset-sm-1 col-sm-11 mt-4">
                                <button type="submit" class="btn bg-dark text-white">Change</button>
                              </div>
                            </div>
                          </form>

                        </div>
                        </div>
                      </div>
                    </div>
                    <a href="{{route('user#userProfile')}}" class="text-black"><i class="fa-solid fa-arrow-left-long fs-3"></i></a><span class="fs-4 ms-1">Back</span>
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
