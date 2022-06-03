@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card-body table-responsive p-0">
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                   <span class="fs-5 ml-5 mt-4">Total - {{$order->total()}} </span>
                    <div class="card-tools d-flex">
                    <a href="{{route('admin#orderListDownLoad')}}"><button class="btn btn-success me-2">Download Csv</button></a>
                   <form action="{{route('admin#searchOrderList')}}" method="get">
                    @csrf
                    <div class="input-group input-group-sm mt-1" style="width: 150px;">
                    <input type="text" name="searchData" value="{{old('searchData')}}" class="form-control float-right" placeholder="Search">

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
                      <th>Customer Name</th>
                      <th>Customer Phone</th>
                      <th>Pizza Name</th>
                      <th>Pizza Count</th>
                      <th>Order Time</th>
                      <th>Payment Status</th>
                      <th>Total Price</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($order as $item)
                  <tr>
                    <td>{{$item->order_id}}</td>
                    <td>{{$item->customer_name}}</td>
                    <td>{{$item->customer_phone}}</td>
                    <td>{{$item->pizza_name}}</td>
                    <td>{{$item->pizza_count}}</td>
                    <td>{{$item->order_time}}</td>
                    <td>
                        @if ($item->payment_status == 1)
                           Credit Card
                        @else
                            Cash
                        @endif
                    </td>
                    <td>{{($item->pizza_price -$item->discount_price)*$item->pizza_count}}</td>
                   {{--  <td>
                      <a href="{{route('admin#updateCategory',$item->category_id)}}"><button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                      <a href="{{route('admin#deleteCategory',$item->category_id)}}"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                    </td> --}}
                  </tr>
                  @endforeach
                  </tbody>
                </table>
                <div class="pagination justify-content-center"> {{$order->links()}}</div>
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
