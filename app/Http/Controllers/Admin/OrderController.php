<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Admin\OrderController;

class OrderController extends Controller
{
    //orderList
    public function orderList(){
        if(Session::has('ORDER_LIST')){
            Session::forget('ORDER_LIST');
        }
        $data=Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',
                 'users.phone as customer_phone','pizzas.price as pizza_price','pizzas.discount_price',
                  DB::raw('count(orders.pizza_id) as pizza_count'))
                 ->join('users','users.id','orders.customer_id')
                 ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                 ->groupBy('orders.customer_id','orders.pizza_id')
                 ->paginate(9);

              /*    dd($data->toArray()); */
        return view('admin.order.list')->with(['order'=>$data]);
    }

    public function searchOrderList(Request $request){
        $data=Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',
                 'users.phone as customer_phone','pizzas.price as pizza_price','pizzas.discount_price',
                  DB::raw('count(orders.pizza_id) as pizza_count'))
                 ->join('users','users.id','orders.customer_id')
                 ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                 ->orwhere('users.name','like','%'.$request->searchData.'%')
                 ->orwhere('pizzas.pizza_name','like','%'.$request->searchData.'%')
                 ->orwhere('users.phone','like','%'.$request->searchData.'%')
                 ->groupBy('orders.customer_id','orders.pizza_id')
                 ->paginate(9);
                 Session::put('ORDER_LIST',$request->searchData);
        $data->append($request->all());
        return view('admin.order.list')->with(['order'=>$data]);
    }
    //csv download
     //csv download
     public function orderListDownload(){
         if(Session::has('ORDER_LIST')){
            $order=Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',
            'users.phone as customer_phone','pizzas.price as pizza_price','pizzas.discount_price',
             DB::raw('count(orders.pizza_id) as pizza_count'))
            ->join('users','users.id','orders.customer_id')
            ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
            ->orwhere('users.name','like','%'.Session::get('ORDER_LIST').'%')
            ->orwhere('pizzas.pizza_name','like','%'.Session::get('ORDER_LIST').'%')
            ->orwhere('users.phone','like','%'.Session::get('ORDER_LIST').'%')
            ->groupBy('orders.customer_id','orders.pizza_id')
            ->get();
         }
         else{
            $order=Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',
            'users.phone as customer_phone','pizzas.price as pizza_price','pizzas.discount_price',
             DB::raw('count(orders.pizza_id) as pizza_count'))
            ->join('users','users.id','orders.customer_id')
            ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
            ->groupBy('orders.customer_id','orders.pizza_id')
            ->get();
         }
        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($order) {
            $order->created_at = $order->created_at->format('Y-m-d');
        });

        $csvExporter->build($order, [
            'order_id' => 'ID',
            'customer_name' => 'Customer Name',
            'customer_phone' =>'Customer Phone',
            'pizza_name'=>'Pizza Name',
            'pizza_count'=>'Pizza Count',
            'order_time'=>'Order Time',
            'payment_status'=>'Payment Status',
            'pizza_price'=>'Pizza price',
            'discount_price'=>'Disxount price',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'orderList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');

    }
}
