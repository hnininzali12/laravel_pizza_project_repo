<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function createContact (Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
     $data = $this->requestContactData($request);
     Contact::create($data);
     return back()->with(['sendSuccess'=>'Message send!']);
    }

    //show contact list
    public function contactList(){
      if(Session::has('CONTACT_LIST')){
          Session::forget('CONTACT_LIST');
      }
      $data =Contact::orderBy('contact_id','desc')
                ->paginate(2);
    if (count($data) ==0) {
        # code...
        $emptyStatus = 0;
    } else {
        $emptyStatus = 1;
    };
      return view('admin.contact.contact')->with(['contact'=>$data,'status'=>$emptyStatus]);
    }

    public function searchContactList(Request $request){
      $searchData = Contact::orwhere('name','like','%'.$request->searchData.'%')
                             ->orwhere('email','like','%'.$request->searchData.'%')
                             ->orwhere('message','like','%'.$request->searchData.'%')
                             ->paginate(2);
      Session::put('CONTACT_LIST',$request->searchData);
     $searchData->append($request->all());
     if (count($searchData) ==0) {
        # code...
        $emptyStatus = 0;
    } else {
        $emptyStatus = 1;
    };
     return view('admin.contact.contact')->with(['contact'=>$searchData,'status'=>$emptyStatus]);
    }

    //download csv
    public function contactListDownload(){
        if(Session::has('CONTACT_LIST')){
            $contact = Contact::orwhere('name','like','%'.Session::get('CONTACT_LIST').'%')
            ->orwhere('email','like','%'.Session::get('CONTACT_LIST').'%')
            ->orwhere('message','like','%'.Session::get('CONTACT_LIST').'%')
            ->get();
        }
        else{
            $contact =Contact::orderBy('contact_id','desc')
            ->get();
        }
       $csvExporter = new \Laracsv\Export();

       $csvExporter->beforeEach(function ($contact) {
           $contact->created_at = $contact->created_at->format('Y-m-d');
       });

       $csvExporter->build($contact, [
           'contact_id' => 'ID',
           'name' => 'Name',
           'email' =>'Email',
           'message'=>'Message',
           'created_at'=>'Created at',
       ]);

       $csvReader = $csvExporter->getReader();

       $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

       $filename = 'contactList.csv';

       return response((string) $csvReader)
           ->header('Content-Type', 'text/csv; charset=UTF-8')
           ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');

   }

    private function requestContactData($request){
        return[
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'message'=>$request->message,
        ];
    }
}
