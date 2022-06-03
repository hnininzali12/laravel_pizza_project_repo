<?php

namespace App\Http\Controllers\Admin;

use Laracsv\Export;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\CategoryController;

class CategoryController extends Controller
{
    //admin home page
    //public function index(){
    //  return view('admin.home');
    //}

      //category
      public function category(){
       // $response=Category::distinct()->get();
       // $data=Category::paginate(5);
       if(Session::has('CATEGORY_LIST')){
        Session::forget('CATEGORY_LIST');
    }
       $data = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                ->leftJoin('pizzas','categories.category_id','pizzas.category_id')
                ->groupBy('categories.category_id')
                ->paginate(5);
        return view('admin.category.list')->with(['category'=>$data]);
    }

    //add category
     public function addCategory(){
         return view('admin.category.add');
     }

    //create category
    public function createCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

    $category=[
        'category_name'=>$request->name,
    ];
    Category::create($category);
    return redirect()->route('admin#category')->with(['addSuccess'=>'Category added...']);
    }

    //delete category
    public function deleteCategory($id){
        Category::where('category_id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Category deleted!']);
    }

    //updateCategory
    public function updateCategory($id){
     $data=Category::where('category_id',$id)->first();
     return view('admin.category.update')->with(['category'=>$data]);
    }

    //edit category
    public function editCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
      $updateCategory=[
          'category_name'=>$request->name,
      ];
      Category::where('category_id',$request->id)->update($updateCategory);
      return redirect()->route('admin#category')->with(['updateSuccess'=>'Category updated!']);
    }

    //search category
    public function searchCategory(Request $request){
        $data= Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
        ->leftJoin('pizzas','categories.category_id','pizzas.category_id')
        ->where('category_name','like','%'.$request->searchData.'%')
        ->groupBy('categories.category_id')
        ->paginate(5);
        Session::put('CATEGORY_LIST',$request->searchData);
        $data->append($request->all());
        return view ('admin.category.list')->with(['category'=>$data]);
    }

    //download csv
    public function categoryListDownload(){
        if(Session::has('CATEGORY_LIST')){
            $category= Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
            ->leftJoin('pizzas','categories.category_id','pizzas.category_id')
            ->where('category_name','like','%'.Session::get('CATEGORY_LIST').'%')
            ->groupBy('categories.category_id')
            ->get();
        }else{
            $category =  Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
            ->leftJoin('pizzas','categories.category_id','pizzas.category_id')
            ->groupBy('categories.category_id')
            ->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($category) {
            $category->created_at = $category->created_at->format('Y-m-d');
        });

        $csvExporter->build($category, [
            'category_id' => 'ID',
            'category_name' => 'Name',
            'count' =>'Product count',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'categoryList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
