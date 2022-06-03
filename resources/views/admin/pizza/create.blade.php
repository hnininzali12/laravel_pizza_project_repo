@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-10 offset-2 mt-5">
            <div class="col-md-9">
              <a href="{{route('admin#pizza')}}"class="text-decoration-none text-black"><div class="mb-3 fs-5"><i class="fa-solid fa-arrow-left-long"></i>Back</div></a>
              <div class="card">
                <div class="card-header p-2">
                  <legend class="text-center">Pizza Categories addition</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <form class="form-horizontal" method="POST" action="{{route('admin#insertPizza')}}" enctype="multipart/form-data">
                       @csrf
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" value="{{old('name')}}" id="inputName" name="name"placeholder="Enter pizza name">
                          </div>
                          @if($errors->has('name'))
                          <p class="text-danger">{{$errors->first('name')}}</p>
                          @endif
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                              <input type="file" class="form-control-file" value="{{old('image')}}" id="inputName" name="image" placeholder="Choose your image">
                            </div>
                            @if($errors->has('image'))
                            <p class="text-danger">{{$errors->first('image')}}</p>
                            @endif
                          </div>
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" id="inputName" value="{{old('price')}}" name="price"placeholder="Enter price">
                            </div>
                            @if($errors->has('price'))
                            <p class="text-danger">{{$errors->first('price')}}</p>
                            @endif
                          </div>
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Public Status</label>
                            <div class="col-sm-10">
                              <select name="publicStatus" class="form-control">
                                  <option value="empty">Choose Status</option>
                                  <option value="1">Publish</option>
                                  <option value="0">Unpublish</option>
                              </select>
                            </div>
                            @if($errors->has('publicStatus'))
                            <p class="text-danger">{{$errors->first('publicStatus')}}</p>
                            @endif
                          </div>
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                              <select name="categoryId" class="form-control">
                                <option value="empty">Choose category</option>
                                @foreach ($category as $item)
                                 <option value="{{$item->category_id}}">{{$item->category_name}}</option>
                                @endforeach
                              </select>
                            </div>
                            @if($errors->has('categoryId'))
                            <p class="text-danger">{{$errors->first('categoryId')}}</p>
                            @endif
                          </div>
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Discount Price</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="inputName" value="{{old('disPrice')}}" name="disPrice"placeholder="Enter discount price">
                            </div>
                            @if($errors->has('disPrice'))
                            <p class="text-danger">{{$errors->first('disPrice')}}</p>
                            @endif
                          </div>
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Buy One Get One</label>
                            <div class="col-sm-10 mt-3">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="buyOneGetOne" id="inlineRadio1" value="1"> Yes
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="buyOneGetOne" id="inlineRadio1" value="2"> No
                              </div>
                            </div>
                            @if($errors->has('buyOneGetOne'))
                            <p class="text-danger">{{$errors->first('buyOneGetOne')}}</p>
                            @endif
                          </div>
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Waiting time</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" id="inputName" value="{{old('waitingTime')}}" name="waitingTime"placeholder="Enter waiting time">
                            </div>
                            @if($errors->has('waitingTime'))
                            <p class="text-danger">{{$errors->first('waitingTime')}}</p>
                            @endif
                          </div>
                          <div class="form-group row">
                            <label for="inputName" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                             <textarea name="description" class="form-control" placeholder="Enter description"cols="30" rows="5">{{old('description')}}</textarea>
                            </div>
                            @if($errors->has('description'))
                            <p class="text-danger">{{$errors->first('description')}}</p>
                            @endif
                          </div>
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                           <input type="submit" value="Add" class="btn btn-dark">
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
