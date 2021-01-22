<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\FeedbackQuestion;
use DB;
use Redirect;
use \MongoDB\BSON\ObjectID as MongoId;

class FeedbackQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
	 public function index(){
		 
		 $all_question=FeedbackQuestion::get();
		 $all_question_count=FeedbackQuestion::get()->count();

		 if($all_question_count>0)
		 {
		 return view('admin.feedback_question.index',compact('all_question'));
		 }
		 else{
			  return redirect('admin/add_question');
		 }
	 }
	 
	 public function add_question(Request $request){
		 return view('admin.feedback_question.add_question');
	 }
	 
	 public function store_question(Request $request){
		 
		 $input=$request->all();
		 // print_r($input);
		 // die();
		 if($input['answer_type']=="rating"||$input['answer_type']=="text"){
			$options=null;			 
		 }
		 else{
			  $options=json_encode($input['options']);
		 }
           $qustion= new FeedbackQuestion;
           $qustion->question=$input['question'];
           $qustion->questionType=$input['question_type'];          
           $qustion->answerType=$input['answer_type'];
           $qustion->options=$options;
           $qustion->save();
		   return redirect('admin/add_question')->with("su_status", "Feedback Question has been added successfully");  
		 // $add_question->type=$data['training_type'];
		 // $add_question->question=$data['question'];
		 // $add_question->save();
		 // return redirect('admin/add_question')->with("su_status", "Question has been added successfully");                  
		 //return redirect();
		 //print_r($data);
	 }


	 public function deleteFeedback($id){
	 	FeedbackQuestion::where('_id', $id)->delete();
		return redirect('admin/all_feedback_question')->with("su_status", "Question Deleted successfully");  
	 }


	 public function editFeedback($id){
	 	$feedback = FeedbackQuestion::where('_id', $id)->first();
		 return view('admin.feedback_question.edit_question',compact('feedback'));
	 }


	 public function update_question(Request $request){
		 $input=$request->all();
		 if($input['answer_type']=="rating"||$input['answer_type']=="text"){
			$options=null;			 
		 }
		 else{
			  $options=json_encode($input['options']);
		 }
           FeedbackQuestion::where('_id', $input['pre_id'])->update([
           		'question' => $input['question'],
           		'questionType' => $input['question_type'],
           		'answerType' => $input['answer_type'],
           		'options' => $options,
           ]);

		   return redirect('admin/all_feedback_question')->with("su_status", "Feedback Question has been updated successfully");  
	 }
	 
	 
}
