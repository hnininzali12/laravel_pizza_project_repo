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
                  <legend class="text-center">Pizza Information</legend>
                </div>
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane d-flex justify-content-center" id="activity">
                      <div class="pr-4 mr-2" style="margin-top:50px">
                          <img class="img-thumbnail rounded-2" src="{{asset('uploads/'.$pizza->image)}}" style="width:300px">
                      </div>
                      <div class="">
                        <div class="mt-3 fs-5">
                            <b>Pizza Name: </b><span> {{$pizza->pizza_name}}</span>
                        </div>
                        <div class="mt-3 fs-5">
                          <b>Price: </b><span> {{$pizza->price}} kyats</span>
                        </div>
                        <div class="mt-3 fs-5">
                            <b>Publish Status: </b>
                          <span>
                              @if ($pizza->publish_status==1)
                              Yes
                          @else
                              No
                          @endif
                          </span>
                        </div>
                        <div class="mt-3 fs-5">
                          <b>Category : </b><span> {{$pizza->category_id}}</span>
                      </div>
                      <div class="mt-3 fs-5">
                          <b>Discount price: </b><span> {{$pizza->discount_price}} kyats</span>
                      </div>
                      <div class="mt-3 fs-5">
                          <b>Buy One Get One: </b><span>
                          @if ($pizza->publish_status==1)
                              Yes
                          @else
                              No
                          @endif
                          </span>
                      </div>
                      <div class="mt-3 fs-5">
                          <b>Waiting Time: </b><span> {{$pizza->waiting_time}}</span>
                      </div>
                      <div class="mt-3 fs-5">
                          <b>Description: </b><span> {{$pizza->description}}</span>
                      </div>
                      </div>
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
