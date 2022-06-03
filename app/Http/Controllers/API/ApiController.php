<?php

namespace App\Http\Controllers\API;
use Response;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //category list
    public function categoryList(){
        $category =Category::get();
        $response =[
            'status'=>'200',
            'message'=>'success',
            'data'=>$category
        ];
        return Response::json($response);
    }

    //create category
    public function createCategory(Request $request){
     $category=[
         'category_name'=>$request->categoryName,
         'created_at'=>Carbon::now(),
         'updated_at'=>Carbon::now(),
     ];
     Category::create($category);
     $response =[
         'status'=>200,
         'message'=>'success',
     ];
     return Response::json($response);
    }

    //detail
    /* public function categoryDetail(Request $request){
        $data =Category::where('category_id',$request->id)->first();
        if(!empty($data)){
            return Response::json([
                'status'=>200,
                'message'=>'success',
                'data'=>$data,
            ]);

        }
        return Response::json([
            'status'=>200,
            'message'=>'success',
            'data'=>$data,
        ]);
    } */
    //detail with get
    public function categoryDetail($id){
        $data =Category::where('category_id',$id)->first();
        if(!empty($data)){
            return Response::json([
                'status'=>200,
                'message'=>'success',
                'data'=>$data,
            ]);

        }
        return Response::json([
            'status'=>200,
            'message'=>'fail',
            'data'=>$data,
        ]);
    }
    //delete
    public function categoryDelete($id){
        $data =Category::where('category_id',$id)->first();
        if(empty($data)){
            return Response::json([
                'status'=>200,
                'message'=>'fail',
            ]);

        }
        Category::where('category_id',$id)->delete();
        return Response::json([
            'status'=>200,
            'message'=>'success',
        ]);
    }

    //update
    public function updateCategory(Request $request){
        $update =[
            'category_id' =>$request->id,
            'category_name' =>$request->categoryName,
            'updated_at'=>Carbon::now()
        ];
        $check=Category::where('category_id',$request->id)->first();
        if(!empty($check)){
            Category::where('category_id',$request->id)->update($update);
            return Response::json([
            'status'=>200,
            'message'=>'success'
        ]);
        }
        return Response::json([
            'status'=>200,
            'message'=>'fail'
        ]);
    }
}
