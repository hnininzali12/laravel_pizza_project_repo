<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\UserAccController;

class UserAccController extends Controller
{
    //user direct page
    //public function user(){
      //  $userData=User::get();
        //return view('admin.user.userList')->with(['user'=>$userData]);
    //}
    //userList direct page
    public function userList(){
        if(Session::has('USERLIST_SEARCH')){
            Session::forget('USERLIST_SEARCH');
        }
        $userData =User::where('role','user')->paginate(3);
        return view('admin.user.userList')->with(['user'=>$userData]);
       }

       //user change role page
       public function userChangeRolePage($id){
           $data =User::where('id',$id)->first();
           return view('admin.user.userChangeRole')->with(['user'=>$data]);
       }
       //user change role
       public function userChangeRole($id,Request $request){
           $data =[
               'role'=>$request->role,
           ];
           User::where('id',$id)->update($data);
           return redirect()->route('admin#userList')->with(['changeRole'=>'User role is changed!']);
       }
      //adminList direct page
      public function adminList(){
        $userData =User::where('role','admin')->paginate(3);
        return view('admin.user.adminList')->with(['admin'=>$userData]);
       }

      //admin list edit page
      public function adminListEdit($id){
        $data=User::where('id',$id)->first();
        return view('admin.user.adminListEdit')->with(['user'=>$data]);
      }
      //admin list update page
      public function adminListUpdate($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=>'required',
            'phone'=>'required',
            'address'=>'required',
            'role'=>'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = $this->requestAdminListUpdate($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#adminList')->with(['updateSuccess'=>'Admin List is successfully updated!']);
      }
      //search user data
      public function searchUser(Request $request){
        $response=$this->search('user',$request);
        Session::put('USERLIST_SEARCH',$request->searchData);
         return view('admin.user.userList')->with(['user'=>$response]);
      }

      //search admin data
      public function searchAdmin(Request $request){
        $response=$this->search('admin',$request);
        Session::put('USERLIST_SEARCH',$request->searchData);
        return view('admin.user.adminList')->with(['admin'=>$response]);
      }

      //csv download
      public function userListDownLoad(){
        if(Session::has('USERLIST_SEARCH')){
            $user=  User::where('role','admin')
            ->where('role','where')
            ->orwhere('name','like','%'.Session::get('USERLIST_SEARCH').'%')
            ->orwhere('email','like','%'.Session::get('USERLIST_SEARCH').'%')
            ->orwhere('phone','like','%'.Session::get('USERLIST_SEARCH').'%')
            ->orwhere('address','like','%'.Session::get('USERLIST_SEARCH').'%')
            ->get();
        }else{
            $user =User::where('role','user')->get();
            $user =User::where('role','admin')->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->beforeEach(function ($user) {
            $user->created_at = $user->created_at->format('Y-m-d');
        });

        $csvExporter->build($user, [
            'id' => 'ID',
            'name' => 'Name',
            'email' =>'email',
            'phone'=>'Phone',
            'address'=>'Address',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'userList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
      }

      //delete user
      public function deleteUser($id){
          User::where('id',$id)->delete();
          return back()->with(['deleteSuccess'=>'User deleted...']);
      }

      //request Admin list update
      private function requestAdminListUpdate($request){
           return[
               'name'=>$request->name,
               'email'=>$request->email,
               'phone'=>$request->phone,
               'address'=>$request->address,
               'role'=>$request->role,
           ];
      }

      //searching user acc
      private function search($role,$request){
                    $searchData = User::where('role',$role);
                    $searchData=$searchData
                    ->where(function ($query) use($request) {
                    $query
                    ->orwhere('name','like','%'.$request->searchData.'%')
                    ->orwhere('email','like','%'.$request->searchData.'%')
                    ->orwhere('phone','like','%'.$request->searchData.'%')
                    ->orwhere('address','like','%'.$request->searchData.'%');
                    })->paginate(3);
            $searchData->appends($request->all());
            return $searchData;
      }
}
