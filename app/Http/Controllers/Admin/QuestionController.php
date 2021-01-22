<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;
use DB;
use Redirect;
use \MongoDB\BSON\ObjectID as MongoId;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 private $ques_obj;
		public function __construct(Questions $questions){
			$this->ques_obj=$questions;
		}
	 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function all_questions($id){
	
		  $_iddd = new MongoId($id);
		 //$question=Questions::where('study','=',$_iddd)->get();
        $question = Questions::orderBy('sort_id','asc')->where('study',$_iddd)->paginate(7);
        //$question=DB::table('questions')->where('study',$id)->paginate(7);
        return view('admin.add_question.index',compact('question','id'));
    }

    public function add_questions(Request $request){
           $input =$request->all();
		   $_iddd = new MongoId($input['study']);
		   // if($input['question_type']=="followUpQuestion")
		   // {
			   // $days=$input['follow_up_day'];
		   // }
		   // else{
			   // $days=null;
		   // }
		   /*if($input['answer_type']="single" ||$input['answer_type']=="multiple"){
			   
			   if(empty($input['options'])){
				         return redirect('admin/all_questions/'.$_iddd)->with("er_status", "Please select insert option first");                  
			   }
		   }*/
		   
		   foreach($input['question_type'] as $ques=>$val)
		   {
			   if($val=='followUpQuestion'){
				   $days=$input['follow_up_day'];
				   if(!empty($days)){
					   $qustion= new Questions;
					   $qustion->question=$input['question'];
					   $qustion->study=$_iddd;           
					   $qustion->questionType=$input['question_type'];          
					   $qustion->answerType=$input['answer_type'];
					   $qustion->follow_up_day=$days;
					   $qustion->options=json_encode($input['options']);
					   $qustion->save();
					  return response()->json(['status'=>true,'data'=>$input, 'message'=>' successfully'], 200);
				   }
			   }
			   else{
				   $days=null;
				     $qustion= new Questions;
           $qustion->question=$input['question'];
           $qustion->study=$_iddd;           
           $qustion->questionType=$input['question_type'];          
           $qustion->answerType=$input['answer_type'];
		   $qustion->follow_up_day=$days;
           $qustion->options=json_encode($input['options']);
           $qustion->save();
          return response()->json(['status'=>true,'data'=>$input, 'message'=>' successfully'], 200);
			   }
		   }
		   
         
		      // $data=$request->all();
		 		// $_iddd = new MongoId($data['study']);

         // $ques_info=$this->ques_obj->addQuestions($data);
        // if ($ques_info) {
                // return response()->json(['status'=>true,'data'=>$data,'_iii'=>$_iddd, 'message'=>' successfully'], 200);                 
                // } 
        // else {
                // return response()->json(['status'=>false,'data'=>$data, 'message'=>' successfully'], 200);
            // }
    }
    public function update_order(Request $request){
           // $input =$request->all();
            // return response()->json(['status'=>true,'data'=>$input, 'message'=>' successfully'], 200);
			 if($request->has('ids')){
                $arr = explode(',',$request->input('ids'));                
                foreach($arr as $sortOrder => $id){
                    $menu = Questions::find($id);
                    $menu->sort_id = $sortOrder;
                    $menu->save();
                }
                return ['success'=>true,'message'=>'Updated','arr'=>$arr];
            }    
    }
   
    public function searchStudy(Request $request){
        $word=$request->search;
        $id=$request->id;
        $qustion= Questions::where('study','=',$id)->where('questionType','LIKE','%'.$word.'%')->get();
        return response()->json(['status'=>true,'data'=>$qustion, 'id'=>$id, 'message'=>' successfully'], 200);
    }

    public function edit_question($id)
    {
        $qustion= Questions::where('_id','=',$id)->first();
        //echo $qustion;die();
        return view('admin.add_question.edit',compact('qustion'));
    }

    public function update_question(Request $request,$id){
            $input =$request->all();
			foreach($input['question_type'] as $val)
		   {
			   if($val=='followUpQuestion'){
				   $days=$input['follow_up_day'];
			   }
			   else{
				   $days=null;
			   }
			   
		   }
            $update_data=[
            'question'=>$input['question'],
            'questionType'=>$input['question_type'],
            'answerType'=>$input['answer_type'],
			'follow_up_day'=>$days,
            'options'=>$input['answer_type']=='text'||$input['answer_type']=='rating'?null:json_encode($input['options']),
            ];
						//print_r($update_data);die();

        $update_qustion= Questions::where('_id','=',$id)->update($update_data);
        
        return redirect('/admin/all_questions/'.$input['study']);
        //return Redirect::back()->with('su_status', 'Question has been updated!');

    }
	
	public function add_duplicate_question(Request $request,$id){
		//echo $id;
		$find_qustion= Questions::find($id);
		$add_question=$find_qustion->replicate();
		$add_question->save();
	    return redirect()->back();
		
	}



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
		    // return response()->json(['status'=>true, 'message'=>' successfully'], 200);
// die();
       $uri_id=$request->route('id');
       $del_question= Questions::where('_id','=',$id)->delete();
	   //return response()->json(['status'=>true, 'message'=>' successfully'], 200);
       return Redirect::back()->with('su_status', 'Question has been deleted successfully!');;
       //return redirect('/admin/all_questions/'.$uri_id);
    }
}
