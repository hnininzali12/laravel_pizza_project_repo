<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\PizzaController;

class PizzaController extends Controller
{
      //pizza
      public function pizza(){
        if(Session::has('PIZZA_SEARCH')){
            Session::forget('PIZZA_SEARCH');
        }
        $data=Pizza::paginate(5);
        if(count($data)==0){
            $emptyStatus = 0;
        }
        else{
            $emptyStatus =1;
        };

        return view('admin.pizza.list')->with(['pizza'=>$data,'empty'=>$emptyStatus]);
    }
    //add pizza direct page
      public function createPizza(){
          $category=Category::get();
          return view('admin.pizza.create')->with(['category'=>$category]);
      }

    //pizza create
    public function insertPizza(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'image'=>'required',
            'price'=>'required',
            'publicStatus'=>'required',
            'disPrice'=>'required',
            'buyOneGetOne'=>'required',
            'categoryId'=>'required',
            'waitingTime'=>'required',
            'description'=>'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
      $file=$request->file('image');
      $fileName=uniqid().'_'.$file->getClientOriginalName();
      $file->move(public_path().'/uploads/',$fileName);
      $data= $this->requestPizzaData($request,$fileName);
      Pizza::create($data);
      return redirect()->route('admin#pizza')->with(['createSuccess'=>'Pizza created!']);
    }

    //delete pizza
    public function deletePizza($id){
     $data=Pizza::select('image')->where('pizza_id',$id)->first();
     $fileName=$data['image'];
     Pizza::where('pizza_id',$id)->delete();
     if(File::exists(public_path().'/uploads/'.$fileName)){
        File::delete(public_path().'/uploads/'.$fileName);
     }
     return redirect()->route('admin#pizza')->with(['deleteSuccess'=>'Pizza category is deleted!']);
    }

    //See more pizza info
    public function pizzaInfo($id){
        $data=Pizza::where('pizza_id',$id)->first();
        return view('admin.pizza.pizzaInfo')->with(['pizza'=>$data]);
    }

    //edit pizza
    public function editPizza($id){
        $category=Category::get();
        $data=Pizza::select('pizzas.*','categories.category_id','categories.category_name')
                            ->join('categories','pizzas.category_id','categories.category_id')
                            ->where('pizza_id',$id)
                            ->first();
        return view('admin.pizza.edit')->with(['pizza'=>$data,'category'=>$category]);
    }

    //updatePizza
    public function updatePizza($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            //'image'=>'required',
            'price'=>'required',
            'publicStatus'=>'required',
            'disPrice'=>'required',
            'buyOneGetOne'=>'required',
            'categoryId'=>'required',
            'waitingTime'=>'required',
            'description'=>'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $updateData = $this->updateRequestPizzaData($request);
        if(isset($updateData['image'])){
            //get old image
            $data=Pizza::select('image')->where('pizza_id',$id)->first();
            $fileName=$data['image'];
            // delete old image
           if(File::exists(public_path().'/uploads/'.$fileName)){
             File::delete(public_path().'/uploads/'.$fileName);
           }
            //get new image
            $file = $request->file('image');
            $fileName=uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/',$fileName);

            $updateData['image'] =$fileName;
        };
            Pizza::where('pizza_id',$id)->update($updateData);
            return redirect()->route('admin#pizza')->with(['updateSuccess'=>'Update success...']);

    }

    //search pizza
    public function searchPizza(Request $request){
        $searchKey=$request->table_search;
        $searchData=Pizza::orwhere('pizza_name','like','%'.$searchKey.'%')
                           ->orwhere('price','like','%'.$searchKey.'%')
                           ->paginate(5);
        Session::put('PIZZA_SEARCH',$searchKey);
        if(count($searchData)==0){
            $emptyStatus = 0;
        }
        else{
            $emptyStatus =1;
        };
        $searchData->append($request->all());
        return view('admin.pizza.list')->with(['pizza'=>$searchData,'empty'=>$emptyStatus]);
    }

    //category item show
    public function categoryItem($id){
        $data =Pizza::select('pizzas.*','categories.category_name as categoryName')
                     ->join('categories','pizzas.category_id','categories.category_id')
                     ->where('categories.category_id',$id)
                     ->paginate(2);
        return view('admin.category.item')->with(['pizza'=>$data]);
    }
     //csv download
     public function pizzaListDownload(){
        if(Session::has('PIZZA_SEARCH')){
            $pizza= Pizza::orwhere('pizza_name','like','%'.Session::get('PIZZA_SEARCH').'%')
            ->orwhere('price','like','%'.Session::get('PIZZA_SEARCH').'%')
            ->get();
        }else{
            $pizza =  Pizza::get();
        }
        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($pizza) {
            $pizza->created_at = $pizza->created_at->format('Y-m-d');
        });

        $csvExporter->build($pizza, [
            'pizza_id' => 'ID',
            'pizza_name' => 'Name',
            'price' =>'Price',
            'publish_status'=>'Publish Status',
            'buy_one_get_one'=>'Buy One Get One',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'pizzaList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');

    }
    //update pizza request data
    private function updateRequestPizzaData($request){
        $arr=[
            'pizza_name'=>$request->name,
            //'image'=>$fileName,
            'price'=>$request->price,
            'publish_status'=>$request->publicStatus,
            'category_id'=>$request->categoryId,
            'discount_price'=>$request->disPrice,
            'buy_one_get_one_status'=>$request->buyOneGetOne,
            'waiting_time'=>$request->waitingTime,
            'description'=>$request->description,
        ];
        if(isset($request->image)){
           $arr['image']=$request->image;
        }
        return $arr;
    }

    //pizza data
    private function requestPizzaData($request,$fileName){
        return[
        'pizza_name'=>$request->name,
        'image'=>$fileName,
        'price'=>$request->price,
        'publish_status'=>$request->publicStatus,
        'category_id'=>$request->categoryId,
        'discount_price'=>$request->disPrice,
        'buy_one_get_one_status'=>$request->buyOneGetOne,
        'waiting_time'=>$request->waitingTime,
        'description'=>$request->description,
        ];
    }
}
