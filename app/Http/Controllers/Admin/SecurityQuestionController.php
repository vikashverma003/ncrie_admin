<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\SecurityQuestions;

class SecurityQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $question_obj;
    public function __construct(SecurityQuestions $securityQuestions){
        $this->question_obj=$securityQuestions;
    }

    public function index()
    {
       $questions=SecurityQuestions::get();
      $questions_count=SecurityQuestions::get()->count();
	   if($questions_count>0)
	   {
       return view('admin.questions.index', compact('questions'));
	   }
	   else{
		   return redirect('/admin/questions/create');
	   }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data=$request->all();
        $question_info=$this->question_obj->createQuestions($data);
        if ($question_info) {
                return redirect('admin/questions')->with("su_status", "Security Question has been added successfully");                  
                } 
        else {
                return Redirect::back()->with('er_status', 'No user  added!');
            }
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
        $questions=SecurityQuestions::where('_id','=',$id)->first();
        return view('admin.questions.edit', compact('questions'));
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
         $updatedData = [
                         'question' => $request->input('question'),
                        ];
                   $update =  SecurityQuestions::where(['_id'=>$id])->update($updatedData);
                   return redirect('admin/questions')->with("su_status", "Security Question  information has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete_question=SecurityQuestions::where('_id','=',$id)->delete();
        return redirect('admin/questions')->with("su_status", "Security Question  information has been deleted");
    }
}
