@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card-body table-responsive p-0">
          {{--  @if (Session::has('addSuccess'))
            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                {{Session::get('addSuccess')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            @if (Session::has('deleteSuccess'))
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                {{Session::get('deleteSuccess')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            @if (Session::has('updateSuccess'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{Session::get('updateSuccess')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif--}}
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  <span class="fs-4 bg-black p-2 mt-3"> {{$pizza[0]->categoryName}}</span>
                   <span class="fs-5 ml-5 mt-4">Total - {{$pizza->total()}} </span>
              </div>
              <!-- /.card-header -->
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Pizza Name</th>
                      <th>Image</th>
                      <th>Price</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($pizza as $item)
                  <tr>
                    <td>{{$item->pizza_id}}</td>
                    <td>{{$item->pizza_name}}</td>
                    <td>
                        <img src="{{asset('uploads/'.$item->image)}}" class="img-thumbnail" style="width: 150px">
                    </td>
                    <td>{{$item->price}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
               <div class="pagination justify-content-center"> {{$pizza->links()}}</div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div>
            <a href="{{route('admin#category')}}" class="text-decoration-none text-black "><i class="fa-solid fa-arrow-left-long fs-3 "></i><span class="fs-4 ml-1">Back</span></a>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection

