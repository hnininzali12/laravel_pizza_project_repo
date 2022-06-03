@extends('admin.layout.app')

@section('content')
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
                      <form class="form-horizontal" method="post" action="{{route('admin#changePassword',auth()->user()->id)}}">
                        @csrf
                        <div class="form-group row mt-3">
                            <span class="col-sm-1 mt-2 fs-5"><i class="fa-solid fa-lock"></i></span>
                          <div class="col-sm-11">
                            <input type="password" class="form-control" name="oldPassword" value="" id="inputName" placeholder="Current password">
                            @if($errors->has('oldPassword'))
                            <p class="text-danger">{{$errors->first('oldPassword')}}</p>
                            @endif
                          </div>
                        </div>
                        </div>
                        <div class="form-group row">
                            <span class="col-sm-1 mt-2 fs-5"><i class="fa-solid fa-key"></i></span>
                          <div class="col-sm-11">
                            <input type="password" class="form-control"name="newPassword" id="inputEmail" value="" placeholder="New password">
                            @if($errors->has('newPassword'))
                            <p class="text-danger">{{$errors->first('newPassword')}}</p>
                            @endif
                          </div>
                        </div>
                        <div class="form-group row">
                            <span class="col-sm-1 mt-2 fs-5"><i class="fa-solid fa-key"></i></span>
                            <div class="col-sm-11">
                              <input type="password" class="form-control"name="confirmPassword" id="inputPhone" value="" placeholder="Re-type new password"  >
                              @if($errors->has('confirmPassword'))
                              <p class="text-danger">{{$errors->first('confirmPassword')}}</p>
                              @endif
                            </div>
                          </div>
                        <div class="form-group row">
                          <div class="offset-sm-1 col-sm-11 mt-4">
                            <button type="submit" class="btn bg-dark text-white">Change</button>
                          </div>
                        </div>
                      </form>

                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
