<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //userprofile page
    public function userProfile(){
        $userId =auth()->user()->id;
        $userData=User::where('id',$userId)->first();
        return view('user.profile.userProfile')->with(['user'=>$userData]);
    }

    //userprofile update
    public function userProfileUpdate($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=>'required',
            'phone'=>'required',
            'address'=>'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data =$this->requestUserProfile($request);
        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'Your profile is updated!']);
    }

    //change password page
    public function userChangePassword(){
        return view('user.profile.changePassword');
    }

    //update password
    public function updatePassword($id,Request $request){
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword'=>'required',
            'confirmPassword'=>'required',
        ],[
            'oldPassword.required'=>"Please fill your current password!",
            'newPassword.required'=>"Please fill your new password!",
            'confirmPassword.required'=>"Please retype your new password!",
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data =User::where('id',$id)->first();
        $dHashValue=$data['password'];
        $oldPassword =$request->oldPassword;
        $newPassword =$request->newPassword;
        $confirmPassword=$request->confirmPassword;
        if(Hash::check($oldPassword,$dHashValue)){
          if($oldPassword != $newPassword){
            if($newPassword != $confirmPassword){
                return back()->with(['passwordNotSame'=>"You must enter the same password twice in order to confirm it..."]);
            }else{
                if(strlen($newPassword <= 6 || $confirmPassword <= 6)){
                    return back()->with(['strlenError'=>'Passwords must be greater than 6 characters...']);
                }else{
                    $hash =Hash::make($newPassword);
                    User::where('id',$id)->update([
                        'password'=>$hash
                    ]);
                    return back()->with(['success'=>"Password is changed..."]);
                }
            }
          }else{
            return back()->with(['passwordSame'=>'New password must be different from current password.']);
          }
        }else{
            return back()->with(['currentPasswordError'=>'Your current password is wrong! Try again...']);
        }
    }
    //user home page
     //admin home page
     public function index(){
        $pizzaData=Pizza::where('publish_status',1)->get();
        $category=Category::get();
        $status=count($pizzaData) == 0?0:1;
        return view('user.home')->with(['pizza'=>$pizzaData,'category'=>$category,'status'=>$status]);
    }

     //pizza search
     public function pizzaSearch($id){
         $pizza =Pizza::where('category_id',$id)->get();
         $category=Category::get();
         $status=count($pizza) == 0?0:1;
         return view('user.home')->with(['pizza'=>$pizza,'category'=>$category,'status'=>$status]);
     }

     //search pizza item with search bar
     public function searchPizzaItem(Request $request){
      $searchData=Pizza::where('pizza_name','like','%'.$request->searchData.'%')->get();
      $category=Category::get();
      $status=count($searchData) == 0?0:1;
      return view('user.home')->with(['pizza'=>$searchData,'category'=>$category,'status'=>$status]);
     }

     //search pizza item with price and time
     public function searchItem(Request $request){
         $min=$request->minPrice;
         $max=$request->maxPrice;
         $startDate=$request->startDate;
         $endDate=$request->endDate;
         $query =Pizza::select('*');
         if(!is_null($startDate) && is_null($endDate)){
            $query=$query->whereDate('created_at','>=',$startDate);
          } else if(is_null($startDate) && !is_null($endDate)){
             $query=$query->whereDate('created_at','<=',$endDate);
          } else if(!is_null($startDate) && !is_null($endDate)){
             $query=$query->whereDate('created_at','>=',$startDate)
                          ->whereDate('created_at','<=',$endDate);
         }
         if(!is_null($min) && is_null($max)){
           $query=$query->where('price','>=',$min);
         } else if(is_null($min) && !is_null($max)){
            $query=$query->where('price','<=',$max);
         } else if(!is_null($min) && !is_null($max)){
            $query=$query->where('price','>=',$min)
                         ->where('price','<=',$max);
        }
        $query=$query->paginate(9);
        $query->appends($request->all());
        $category=Category::get();
        $status=count($query) == 0?0:1;
        return view('user.home')->with(['pizza'=>$query,'category'=>$category,'status'=>$status]);
     }

      //pizza detail
      public function pizzaDetails($id){
        $pizzaData = Pizza::where('pizza_id',$id)->first();
        Session::put('PIZZA_INFO',$pizzaData);
        return view('user.pizza.details')->with(['pizza'=>$pizzaData]);
    }

    //pizza order page
    public function pizzaOrder(){
        $pizzaInfo =Session::get('PIZZA_INFO');
        return view('user.pizza.order')->with(['pizza'=>$pizzaInfo]);
    }

   //pizza placeOrder
   public function placeOrder(Request $request){
    $validator = Validator::make($request->all(), [
        'pizzaCount' => 'required',
        'payment' => 'required',
    ],[
        'pizzaCount.required'=>"Please fill count of pizza how much you want!",
        'payment.required'=>"Please fill payment method!"
    ]);

    if ($validator->fails()) {
        return back()
                    ->withErrors($validator)
                    ->withInput();
    }
       $userId=auth()->user()->id;
       $pizzaInfo =Session::get('PIZZA_INFO');
       $pizzaCount=$request->pizzaCount;
       $waitingTime=$pizzaInfo['waiting_time']*$pizzaCount;
       $totalPrice=($pizzaInfo['price']-$pizzaInfo['discount_price'])*$pizzaCount;
       $orderData=$this->requestOrderData($request,$pizzaInfo,$userId);
       for ($i=0; $i <$pizzaCount ; $i++) {
        Order::create($orderData);
       };
       return back()->with(['totalTime'=>$waitingTime,'totalPrice'=>$totalPrice]);
   }

   //order data
   private function requestOrderData($request,$pizzaInfo,$userId){
       return[
           'customer_id'=>$userId,
           'pizza_id'=>$pizzaInfo['pizza_id'],
           'carrier_id'=>0,
           'payment_status'=>$request->payment,
           'order_time'=>Carbon::now(),
       ];
   }
     //user profile request
     private function requestUserProfile($request){
        return[
            'name'=>$request->name,
            'email'=>$request->email,
            'phone' =>$request->phone,
            'address'=>$request->address,
        ];
    }
}
