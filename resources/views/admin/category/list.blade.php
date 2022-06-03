@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card-body table-responsive p-0">
            @if (Session::has('addSuccess'))
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
            @endif
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <a href="{{route('admin#addCategory')}}"><button class="btn btn-sm btn-outline-dark mt-1">Add Category</button></a>
                </h3>
                   <span class="fs-5 ml-5 mt-4">Total - {{$category->total()}} </span>
                <div class="card-tools d-flex">
                    <a href="{{route('admin#categoryListDownload')}}"><button class="btn btn-success me-2">Download Csv</button></a>
                   <form action="{{route('admin#searchCategory')}}" method="get">
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
                      <th>Category Name</th>
                      <th>Product count</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($category as $item)
                  <tr>
                    <td>{{$item->category_id}}</td>
                    <td>{{$item->category_name}}</td>
                    <td>
                        @if ($item->count ==0)
                           <a href="#" class="text-decoration-none text-black">{{$item->count}}</a>
                        @else
                            <a href="{{route('admin#categoryItem',$item->category_id)}}" class="text-decoration-none text-black">{{$item->count}}</a>
                        @endif
                    </td>
                    <td>
                      <a href="{{route('admin#updateCategory',$item->category_id)}}"><button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                      <a href="{{route('admin#deleteCategory',$item->category_id)}}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                <div class="pagination justify-content-center"> {{$category->links()}}</div>
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
