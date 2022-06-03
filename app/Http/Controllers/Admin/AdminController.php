<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\AdminController;

class AdminController extends Controller
{
      //admin profile
      public function profile(){
        $id=auth()->user()->id;
        $userData=User::where('id',$id)->first();
        return view('admin.profile.index')->with(['user'=>$userData]);
    }

    //update admin profile
    public function updateProfile($id,Request $request){
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
      $userData=$this->requestUserData($request);
      User::where('id',$id)->update($userData);
      return redirect()->route('admin#profile')->with(['updateSuccess'=>'Profile updated!']);
    }

    //change password page
    public function changePasswordPage(){
        return view('admin.profile.changePassword');
    }

    //change password case
    public function changePassword($id,Request $request){
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
        $data=User::where('id',$id)->first();
        $dbHashValue =$data['password'];
        $oldPassword =$request->oldPassword;
        $newPassword=$request->newPassword;
        $confirmPassword=$request->confirmPassword;
        if(Hash::check($oldPassword,$dbHashValue)){
           if($newPassword != $oldPassword){
              if($newPassword != $confirmPassword){
                return back()->with(['passwordNotSame'=>"You must enter the same password twice in order to confirm it..."]);
              }else{
                if(strlen($newPassword<=6 || $confirmPassword<=6)){
                    return back()->with(['strlenError'=>'Passwords must be greater than 6 characters...']);
                }else{
                    $hash =Hash::make($newPassword);
                    User::where('id',$id)->update([
                        'password'=>$hash]);
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
    //request user data
    private function requestUserData($request){
        return[
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
        ];
    }
}
