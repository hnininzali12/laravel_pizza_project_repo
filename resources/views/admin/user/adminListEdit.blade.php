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
                  <legend class="text-center">User Profile</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" method="post" action="{{route('admin#adminListUpdate',$user->id)}}">
                        @csrf
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="{{old('name',$user->name)}}" id="inputName" placeholder="Name">
                            @if($errors->has('name'))
                            <p class="text-danger">{{$errors->first('name')}}</p>
                            @endif
                          </div>
                        </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                            <input type="email" class="form-control"name="email" id="inputEmail" value="{{old('email',$user->email)}}"  placeholder="Email">
                            @if($errors->has('email'))
                            <p class="text-danger">{{$errors->first('email')}}</p>
                            @endif
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPhone" class="col-sm-2 col-form-label" >Phone</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control"name="phone" id="inputPhone" value="{{old('phone',$user->phone)}}"  placeholder="Phone">
                              @if($errors->has('phone'))
                              <p class="text-danger">{{$errors->first('phone')}}</p>
                              @endif
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="address" id="inputAddress"value="{{old('address',$user->address)}}"  placeholder="Address">
                              @if($errors->has('address'))
                              <p class="text-danger">{{$errors->first('address')}}</p>
                              @endif
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputAddress" class="col-sm-2 col-form-label">Change User role</label>
                            <div class="col-sm-10">
                              <select name="role" id="" class="form-control">
                                  <option value="empty">Choose User role</option>
                                  @if ($user->role == 'user')
                                  <option value="user" selected>User</option>
                                  <option value="admin">Admin</option>
                                  @elseif($user->role == 'admin')
                                  <option value="user">User</option>
                                  <option value="admin" selected>Admin</option>
                                  @endif
                              </select>
                              @if($errors->has('role'))
                              <p class="text-danger">{{$errors->first('role')}}</p>
                              @endif
                            </div>
                        {{-- <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <a href="{{route('admin#changePasswordPage')}}">Change Password</a>
                          </div>
                        </div> --}}
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn bg-dark text-white">Change</button>
                          </div>
                        </div>
                      </form>

                    </div>
                    </div>
                  </div>
                </div>
                <a href="{{route('admin#adminList')}}"class="text-decoration-none text-black"><div class="mb-3 fs-5"><i class="fa-solid fa-arrow-left-long"></i>Back</div></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection
