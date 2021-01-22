<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Study;
use DataTables;

class StudyController extends Controller
{
    private $study;
    public function __construct(Study $study){
        $this->study=$study;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title="Study List";
        $study=Study::paginate(7);
        $study_count=Study::get()->count();
		if($study_count>0)
		{
        return view('admin.study.index',compact('title','study'));
		}
		else{
			return redirect('/admin/study/create');
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user=Auth::user();
        $title="Manage Study";
        $condition=[
            'ABM'=> "ABM_WITH_WORDS",
            'ABMF'=> "ABM_WITH_FACES",
            'ACT'=> "ACT_WITH_WORDS",
            'ACTF'=>"ACT_WITH_FACES",
            'PLACEBO'=>"PLACEBO_WITH_WORDS",
            'PLACEBOF'=> "PLACEBO_WITH_FACES",
            'QUESTIONS'=> "QUESTIONS"
          ];
        return view('admin.study.create',compact('title','condition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        $request->validate([
            'name'=>'required',
            'training_cycle'=>'required',
            'maximum_days'=>'required',
            'assessment_duration'=>'required',
            'assessment_trial_count'=>'required',
            'training_duration'=>'required',
            'training_trial_count'=>'required',
            //'total_days'=>'required',
            'condition'=>'required'
        ]);
        $data=$request->all();
		//echo $data['maximum_days'];die();	
		//echo  $data['name'];
		$check_study=Study::where('studyId',$data['name'])->first();
		if(empty($check_study))
        {			
		if($data['training_cycle']==1){
			$data['totalStudyDays']=9;		
			$data['totalExtendedDays']=9+$data['maximum_days'];		
		}
		else if($data['training_cycle']==2){
		  $data['totalStudyDays']=17;		
		  $data['totalExtendedDays']=17+$data['maximum_days'];		
		}
		else if($data['training_cycle']==3){
					  $data['totalStudyDays']=25;		
					  $data['totalExtendedDays']=25+$data['maximum_days'];		

		}
		else if($data['training_cycle']==4){
					  $data['totalStudyDays']=33;		
					  $data['totalExtendedDays']=33+$data['maximum_days'];		

		}
		else if($data['training_cycle']==5){
					  $data['totalStudyDays']=41;		
					  $data['totalExtendedDays']=41+$data['maximum_days'];		

		}
		else if($data['training_cycle']==6){
			 $data['totalStudyDays']=49;		
			 $data['totalExtendedDays']=49+$data['maximum_days'];		
			
		}
		
		
        if($this->study->createStudy( $data)){
            //die("success");
            return redirect('admin/study')->with("su_status", "Study has been created successfully");                  

        }else{
            die('failed');
        }
		}
		else
		{
			  return redirect('admin/study/create')->with("er_status", "Please enter unique study name");                  

		}
    }

    public function training_cycle(Request $request){
       // $training_cycle=3;
       $training_cycle=$request->search;
        //$all_data=array();
        if($training_cycle==1)
        {
            for($i=1;$i<=9;$i++){

                if($i==1 || $i==9){

                    $all_data[]='Assessment Day'.$i;
                }
                else{
                    $all_data[]='Training Day'.$i;
                }
            }
        }
        else if($training_cycle==2){
            for($i=1;$i<=17;$i++){
             if($i==1 || $i==9 ||$i==17){

                    $all_data[]='Assessment Day'.$i;
                }
                else{
                    $all_data[]='Training Day'.$i;
                }
            }
        } 
        else if($training_cycle==3){
         for($i=1;$i<=25;$i++){
                     if($i==1 || $i==9 ||$i==17 ||$i==25){

                            $all_data[]='Assessment Day'.$i;
                        }
                        else{
                            $all_data[]='Training Day'.$i;
                        }
                    }            
        }  
        else if($training_cycle==4){
         for($i=1;$i<=33;$i++){
                     if($i==1 || $i==9 ||$i==17 ||$i==25||$i==33){

                            $all_data[]='Assessment Day'.$i;
                        }
                        else{
                            $all_data[]='Training Day'.$i;
                        }
                    }            
        }  
         else if($training_cycle==5){
         for($i=1;$i<=41;$i++){
                     if($i==1 || $i==9 ||$i==17 ||$i==25 ||$i==33 ||$i==41){

                            $all_data[]='Assessment Day'.$i;
                        }
                        else{
                            $all_data[]='Training Day'.$i;
                        }
                    }            
        } 
        else if($training_cycle==6){
         for($i=1;$i<=49;$i++){
                     if($i==1 || $i==9 ||$i==17 ||$i==25 ||$i==33||$i==41 ||$i==49){

                            $all_data[]='Assessment Day'.$i;
                        }
                        else{
                            $all_data[]='Training Day'.$i;
                        }
                    }            
        }
      return response()->json(['status'=>true,'data'=>$all_data, 'message'=>' successfully'], 200);

        // echo "<pre>";
        // print_r($all_data);die();  

    }


    public function each_study_data($id){
        //echo $id;
         $study=Study::where('_id','=',$id)->first();
         
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
    public function destroy($id)
    {
        //
    }
    public function studyData()
   {
    return DataTables::of(Study::select('studyId','trainingCycle','maximumDays','createdAt')->get())->make(true);
   }
}
