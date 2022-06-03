@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card-body table-responsive p-0">
       {{--      @if (Session::has('addSuccess'))
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
            @endif --}}
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-tools d-flex">
                    <a href="{{route('admin#contactListDownload')}}"><button class="btn btn-success me-2">Download Csv</button></a>
                   <form action="{{route('admin#searchContactList')}}" method="get">
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
                      <th>Message</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($status==0)
                    <tr>
                        <td colspan="4">
                            <div class="text-muted">There is no data</div>
                        </td>
                    </tr>
                @else
                  @foreach ($contact as $item)
                  <tr>
                    <td>{{$item->contact_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->message}}</td>
                  </tr>
                  @endforeach
                  @endif
                  </tbody>
                </table>
                <div class="pagination justify-content-center"> {{$contact->links()}}</div>
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

