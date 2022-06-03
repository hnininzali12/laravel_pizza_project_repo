@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card-body table-responsive p-0">
           @if (Session::has('deleteSuccess'))
          <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
              {{Session::get('deleteSuccess')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
          @if (Session::has('updateSuccess'))
          <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
              {{Session::get('updateSuccess')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title mr-2">
                  <a href="{{route('admin#userList')}} "><button class="btn btn-sm btn-outline-dark mt-1">User List</button></a>
                </h3>
                <h3 class="card-title">
                    <a href="{{route('admin#adminList')}}"><button class="btn btn-sm btn-outline-dark mt-1">Admin List</button></a>
                  </h3>
                <div class="card-tools d-flex">
                    <a href="{{route('admin#userListDownload')}}"><button class="btn btn-success me-2">Download Csv</button></a>
                   <form action="{{route('admin#searchAdmin')}}" method="get">
                    @csrf
                    <div class="input-group input-group-sm mt-1" style="width: 150px;">
                    <input type="text" name="searchData" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.card-header -->
                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($admin as $item)
                  <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->phone}}</td>
                    <td>{{$item->address}}</td>
                    <td>
                      <a href="{{route('admin#adminListEdit',$item->id)}}"><button class="btn btn-sm bg-dark text-white"><i class="fa-solid fa-user-pen"></i></button></a>
                      <a href="{{route('admin#deleteUser',$item->id)}}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                {{--<div class="pagination justify-content-center"> {{$category->links()}}</div>--}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
