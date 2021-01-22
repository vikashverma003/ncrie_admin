<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\PopUpMessage;
class PopUpMessageController extends Controller
{
    /**
     * Login page
     */
	 
	 public function add_message(Request $request){
	
		return view('admin.pop_up.create');
	 }
	 public function store_message(Request $request){
		 
		 $data=$request->all();
		 // print_r($data);
		 // die();
		 // $pop_up_message = PopUpMessage::create($data);
		  $pop_up_message = new PopUpMessage;
		  $pop_up_message->day=(int)$data['day'];
		  $pop_up_message->message=$data['message'];
		  $pop_up_message->save();
		return redirect('admin/show_messages')->with("su_status", "Message has been added successfully");                  
		 
	 }
	 
	 public function show_messages(Request $request){
		 
		 $show_all=PopUpMessage::get();
		 $show_all_count=PopUpMessage::get()->count();
		 if($show_all_count>0)
		 {
		 return view('admin.pop_up.show',compact('show_all'));
		 }
		 else{
			 return redirect('/admin/add_message');
		 }
	 }
	 
	 public function edit_message(Request $request,$id){
	 		 $pop_up_message = PopUpMessage::where('_id',$id)->first();
		     return view('admin.pop_up.edit_message',compact('pop_up_message'));
	 }	 
	 public function update_message(Request $request,$id){
		 
			$data=$request->all();
			$update_date=['day'=>(int)$data['day'],'message'=>$data['message']];
			//print_r($data);die();
	 		 $pop_up_message = PopUpMessage::where('_id',$id)->update($update_date);
		return redirect('admin/show_messages')->with("su_status", "Message has been updated successfully");                  
	 }
  
}
