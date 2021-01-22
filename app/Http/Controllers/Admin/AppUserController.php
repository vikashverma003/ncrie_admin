<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\Study;
use App\Models\Questions;
use App\Models\Word;
use Response;
use DB;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use File;
//use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Carbon;
use \MongoDB\BSON\ObjectID as MongoId;
use Hash;
class AppUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $user_obj;
    public function __construct(User $user){
        $this->user_obj=$user;
    }

    public function index()
    {
       
			 $user_count=User::get()->count();
			 if($user_count>0)
			 {
            $title="User List";
            //$user=User::paginate(7);
            $user=User::get();
            foreach($user as $users){
                $study=Study::where('_id','=',$users->study)->first();
				if(!empty($study))
				{
                $users_info[]=[
                'studyId'=>$study->studyId,
                'study_id'=>$users->study,
                'userId'=>$users->userId,
                'pin'=>$users->pin,

                'userType'=>$users->userType,
                'options'=>$users->options,
                '_id'=>$users->_id,
                ];
				}
            }
            // echo "<pre>";
            // print_r($users_info);die();
            return view('admin.users.index3',compact('title','users_info','user'));
			 }
			 else
			 {
				 return redirect('admin/users/create');
			 }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $study=Study::get();  
        $Id=$this->generateUniqueId(5);
        $n=$Id;
        return view('admin.users.create', compact('study','n'));
    }

    function generateUniqueId($length)
        {
            $number = '';

            do {
                for ($i=$length; $i--; $i>0) {
                    $number .=mt_rand(0,9);
                }
            } while ( !empty(DB::table('users')->where('userId', 'RR'.$number)->first(['userId'])) );

            return 'RR'.$number;
        }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //print_r($_POST);die();
         $data=$request->all();
         $user_info=$this->user_obj->createUser($data);
        if ($user_info) {
                return redirect('admin/users')->with("su_status", "User has been added successfully");                  
                } 
        else {
                return Redirect::back()->with('er_status', 'No user  added!');
            }
            
    }
	
	public function generate_report(Request $request,$i){
				$_iddd = new MongoId($i);
		$users_data=DB::table('userstudyanswers')->where('user', $_iddd)->get();
		
		$all_data=[];
		$t=array();
		$dataUser = User::where('_id', $i)->value('userId');

		foreach($users_data as $users_datas){
			$k=$users_datas['answers'];
			$_user = new MongoId($users_datas['user']);
			$users_info=User::where('_id',$_user)->first();
			// echo "<pre>";
			// print_r($users_info);
			// die();
			//array_push($all_data,$k);
				
			foreach($k as $kk)
			{
				if(!empty($kk['question']))
				{
				$question_id=$kk['question'];			
				$_ques = new MongoId($question_id);
				$ques=Questions::where('_id',$_ques)->first();
				$all_data['question']=$ques->question;
				$all_data['day']=$users_datas['day'];
				//$all_data['created_at']=$users_datas['updatedAt'];
				$convert_date=$users_datas['updatedAt']/1000;
				
				$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);
				//$all_data['question_type']=$ques->questionType;
				if(is_array($ques->questionType)){
					$all_data['question_type']=implode(',',$ques->questionType);
				}
				else{
					$all_data['question_type']=$ques->questionType;
				}
				
				$all_data['userId']=$users_info->userId;
				$all_data['type']='Q&A';
				//$all_data['answer']=$kk['answer'];
				
				$all_data['threat_stimuli']="None";
				$all_data['neutral_stimuli']="None";
				$all_data['threat_position']="None";
				$all_data['probe_position']="None";
				$all_data['probe']="None";
				$all_data['probe_selected']="None";
				if(is_array($kk['answer']))
				{
					$all_data['response']=implode(',',$kk['answer']);
				}
				else{
					$all_data['response']=$kk['answer'];

				}
				$all_data['timeTakenToAnswer']="None";
				}
				else
				{
			    $word_id=$kk['stimuli'];	
				$_word = new MongoId($word_id);
				$word=Word::where('_id',$_word)->first();
				if(!empty($word))
				{
					$word_face=$word->word_face;
					if($word_face=='word'){
					$all_data['question']="None";
					$all_data['question_type']="None";
					$all_data['answer']="None";

					$all_data['threat_stimuli']=$word->threat_word;
					$all_data['neutral_stimuli']=$word->neutral_word;
					$all_data['threat_position']=$word->threat_position;
					$all_data['probe_position']=$word->probe_position;
					//$all_data['created_at']=$users_datas['updatedAt'];
					$convert_date=$users_datas['updatedAt']/1000;
					$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);

					$all_data['probe']=$word->probe;
					$all_data['day']=$users_datas['day'];

					$all_data['timeTakenToAnswer']=$kk['timeTakenToAnswer']*0.001;
					$all_data['probe_selected']=$kk['answer'];
					if($word->probe==$kk['answer']){
					  $all_data['response']="Success";
					}
					else{
						$all_data['response']="Failure";
					}
					
					$all_data['userId']=$users_info->userId;
					$all_data['type']='Words';
					}
					else{
					$all_data['question']="None";
					$all_data['question_type']="None";
					$all_data['answer']="None";

					$all_data['threat_stimuli']=$word->threat_faces;
					$all_data['neutral_stimuli']=$word->neutral_faces;
					$all_data['threat_position']=$word->threat_position;
					$all_data['probe_position']=$word->probe_position;
					//$all_data['created_at']=$users_datas['updatedAt'];
					$convert_date=$users_datas['updatedAt']/1000;
					$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);

					$all_data['probe']=$word->probe;
					$all_data['day']=$users_datas['day'];

					$all_data['timeTakenToAnswer']=$kk['timeTakenToAnswer']*0.001;
					$all_data['probe_selected']=$kk['answer'];
					if($word->probe==$kk['answer']){
					  $all_data['response']="Success";
					}
					else{
						$all_data['response']="Failure";
					}
					
					$all_data['userId']=$users_info->userId;
					$all_data['type']='Faces';
						
					}

				}
				   // echo "<pre>";
				   // print_r($all_data);die();
					}
					array_push($t,$all_data);
					
			}	
		}
		           // echo "<pre>";
				   // print_r($t);die();
		// foreach($t as $id => $brand)
		// {
			// echo "<pre>";
			// print_r($brand);	
		// }		   
				// die();
            $filename = $dataUser.".csv";
            $filename_copy = $dataUser.".csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('PID','Day','Type','Question','ThreatStimuli','NeutralStimuli','Probe','ThreatPosition','ProbePosition','ProbeSelected','Response','ResponseTime', 'created_at'));

            foreach($t as $i=>$row) {
                fputcsv($handle, array($row['userId'],$row['day'],$row['type'],$row['question'], $row['threat_stimuli'], $row['neutral_stimuli'] ,$row['probe'],$row['threat_position'],  $row['probe_position'],$row['probe_selected'],$row['response'],$row['timeTakenToAnswer'],$row['created_at']));
            }

            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, $filename_copy, $headers);
		
	}

    public function change_pin(Request $request){
        //echo 232;
                 $data=$request->pin;
				 $laravel_hash=Hash::make($data);
		         $finalNodeGeneratedHash = str_replace("$2y$", "$2a$", $laravel_hash);
                 $user_id=$request->user_id;
                 $user=User::where('_id','=', $user_id)->update(['hashed_password'=>$finalNodeGeneratedHash,'pin'=>$data]);
              return response()->json(['status'=>true,'data'=>$user,'res'=>$request->all(), 'info'=>$data, 'message'=>' successfully'], 200);
    }

    public function single_user(Request $request){

        $user_id=$request->user_id;                
         $user=User::where('_id','=', $user_id)->first();
         $study=Study::where('_id','=',$user->study)->first();
         return response()->json(['status'=>true,'data'=>$user, 'study'=>$study, 'message'=>' successfully'], 200);

    }

    public function search_users(Request $request){

        $user=$request->userId;
        $users= User::where('userId','LIKE','%'.$user.'%')->get();
         foreach($users as $users){
                $study=Study::where('_id','=',$users->study)->first();				

				if(!empty($study)){
				//$check_id=$users->study;
				//$studyy_idd = new MongoId($check_id);
                $users_info[]=[
                'studyId'=>$study->studyId,
                'study_id'=>$users->study,
                'studyy_idd'=>$study->_id,
                'userId'=>$users->userId,
                'uuuserId'=>$users->userId,
                'userType'=>$users->userType,
                'options'=>$users->options,
                '_id'=>$users->_id,
                ];
				}
            }

         return response()->json(['status'=>true,'data'=>$users_info, 'message'=>' successfully'], 200);

    }

    public function download_csv_single_user(Request $request,$id){

            $table = User::where('_id','=',$id)->first();
            $study=Study::where('_id','=',$table->study)->first();
            //$filename = "user_info.csv";
			$user_id=$table->userId;
            $filename = $user_id.".csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array( 'userId','Option', 'study', 'pin'));
            //foreach($table as $row) {
                //fputcsv($handle, array($row['userType'], $row['userId'], $row['study'], $row['pin']));
            //}
                fputcsv($handle, array( $table['userId'],$table['options'], $study['studyId'], $table['pin']));
            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, $user_id.".csv", $headers);
    }


    public function download_csv_all_user(Request $request){

            $table = User::get();
            $table_count = User::get()->count();
			
				// Get all files in a directory
				
				$dir=public_path()."/myFiles/";				
				$file = new Filesystem;
                $file->cleanDirectory($dir);
				$count_row=1;
				$file_path=public_path()."/myFiles/";
				$allArray = array();
		        foreach($table as $row) {
				 $user_id=$row['userId'];
						$_iddd = new MongoId($row['_id']);
		$users_data=DB::table('userstudyanswers')->where('user', $_iddd)->get();
		$all_data=[];
		$t=array();
		$dataUser = User::where('_id', $row['_id'])->value('userId');

		foreach($users_data as $users_datas){
			$k=$users_datas['answers'];
			$_user = new MongoId($users_datas['user']);
			$users_info=User::where('_id',$_user)->first();
				
			foreach($k as $kk)
			{
					if(!empty($kk['question']))
				{
				$question_id=$kk['question'];			
				$_ques = new MongoId($question_id);
				$ques=Questions::where('_id',$_ques)->first();
				$all_data['question']=$ques->question;
				$all_data['day']=$users_datas['day'];
				//$all_data['created_at']=$users_datas['updatedAt'];
				$convert_date=$users_datas['updatedAt']/1000;
				
				$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);
				//$all_data['question_type']=$ques->questionType;
				if(is_array($ques->questionType)){
					$all_data['question_type']=implode(',',$ques->questionType);
				}
				else{
					$all_data['question_type']=$ques->questionType;
				}
				
				$all_data['userId']=$users_info->userId;
				$all_data['type']='Q&A';
				//$all_data['answer']=$kk['answer'];
				
				$all_data['threat_stimuli']="None";
				$all_data['neutral_stimuli']="None";
				$all_data['threat_position']="None";
				$all_data['probe_position']="None";
				$all_data['probe']="None";
				$all_data['probe_selected']="None";
				if(is_array($kk['answer']))
				{
					$all_data['response']=implode(',',$kk['answer']);
				}
				else{
					$all_data['response']=$kk['answer'];

				}
				$all_data['timeTakenToAnswer']="None";
				}
				else
				{
			    $word_id=$kk['stimuli'];	
				$_word = new MongoId($word_id);
				$word=Word::where('_id',$_word)->first();
				if(!empty($word))
				{
					$word_face=$word->word_face;
					if($word_face=='word'){
					$all_data['question']="None";
					$all_data['question_type']="None";
					$all_data['answer']="None";

					$all_data['threat_stimuli']=$word->threat_word;
					$all_data['neutral_stimuli']=$word->neutral_word;
					$all_data['threat_position']=$word->threat_position;
					$all_data['probe_position']=$word->probe_position;
					//$all_data['created_at']=$users_datas['updatedAt'];
					$convert_date=$users_datas['updatedAt']/1000;
					$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);

					$all_data['probe']=$word->probe;
					$all_data['day']=$users_datas['day'];

					$all_data['timeTakenToAnswer']=$kk['timeTakenToAnswer']*0.001;
					$all_data['probe_selected']=$kk['answer'];
					if($word->probe==$kk['answer']){
					  $all_data['response']="Success";
					}
					else{
						$all_data['response']="Failure";
					}
					
					$all_data['userId']=$users_info->userId;
					$all_data['type']='Words';
					}
					else{
					$all_data['question']="None";
					$all_data['question_type']="None";
					$all_data['answer']="None";

					$all_data['threat_stimuli']=$word->threat_faces;
					$all_data['neutral_stimuli']=$word->neutral_faces;
					$all_data['threat_position']=$word->threat_position;
					$all_data['probe_position']=$word->probe_position;
					//$all_data['created_at']=$users_datas['updatedAt'];
					$convert_date=$users_datas['updatedAt']/1000;
					$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);

					$all_data['probe']=$word->probe;
					$all_data['day']=$users_datas['day'];

					$all_data['timeTakenToAnswer']=$kk['timeTakenToAnswer']*0.001;
					$all_data['probe_selected']=$kk['answer'];
					if($word->probe==$kk['answer']){
					  $all_data['response']="Success";
					}
					else{
						$all_data['response']="Failure";
					}
					
					$all_data['userId']=$users_info->userId;
					$all_data['type']='Faces';
						
					}

				}
				   // echo "<pre>";
				   // print_r($all_data);die();
					}
					array_push($t,$all_data);
			}
				
		} 
		
		$allArray[$dataUser] = $t;
				}
			
				// Get all files in a directory
				
				$dir=public_path()."/myFiles/";				
				$file = new Filesystem;
                $file->cleanDirectory($dir);
				$count_row=1;
				$file_path=public_path()."/myFiles/";
		        foreach($allArray as $key => $rowID) {
		        // if(!empty($rowID)){
		            //$filename = public_path()."/myFiles/".$row['userId'].".csv";
				    $filename = public_path()."/myFiles/".$key.".csv";
		            $handle = fopen($filename, 'w+');
		            fputcsv($handle, array('PID','Day','Type','Question','ThreatStimuli','NeutralStimuli','Probe','ThreatPosition','ProbePosition','ProbeSelected','Response','ResponseTime', 'created_at'));

		            foreach($rowID as $i=>$row) {
		                fputcsv($handle, array($row['userId'],$row['day'],$row['type'],$row['question'], $row['threat_stimuli'], $row['neutral_stimuli'] ,$row['probe'],$row['threat_position'],  $row['probe_position'],$row['probe_selected'],$row['response'],$row['timeTakenToAnswer'],$row['created_at']));
		            }

					fclose($handle);
						$headers = array(
							'Content-Type' => 'text/csv',
						);
						$count_row++;
					// }
				}
				
				$zip = new ZipArchive;
				$current = time(); 
				$fileName ="allUsers".$current.".zip";	
				//$fileName = 'myNewFile.zip';		   
				if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
				{
					$files = File::files(public_path('myFiles'));
		   
					foreach ($files as $key => $value) {
						$relativeNameInZipFile = basename($value);
						$zip->addFile($value, $relativeNameInZipFile);
					}
					 
					$zip->close();
				}
				return response()->download(public_path($fileName));
    }
	
	public function multiple_download_user(Request $request){
		
		    $data=$request->all();
		    $id=$data['options']; 					
			$table = User::whereIn('userId',$id)->get();
			return response()->json(['status'=>true,'data'=>$table, 'message'=>' successfully'], 200);	
	}
	
	
	public function multiple_download_user1(Request $request,$id){		
		    $data=$request->all();
			$d=explode(',',$id);
			$table = User::whereIn('userId',$d)->get();
				$dir=public_path()."/myFiles/";				
				$file = new Filesystem;
                $file->cleanDirectory($dir);
				$count_row=1;
				$file_path=public_path()."/myFiles/";
				$allArray = array();
		        foreach($table as $row) {
				 $user_id=$row['userId'];
						$_iddd = new MongoId($row['_id']);
		$users_data=DB::table('userstudyanswers')->where('user', $_iddd)->get();
		$all_data=[];
		$t=array();
		$dataUser = User::where('_id', $row['_id'])->value('userId');

		foreach($users_data as $users_datas){
			$k=$users_datas['answers'];
			$_user = new MongoId($users_datas['user']);
			$users_info=User::where('_id',$_user)->first();
				
			foreach($k as $kk)
			{
					if(!empty($kk['question']))
				{
				$question_id=$kk['question'];			
				$_ques = new MongoId($question_id);
				$ques=Questions::where('_id',$_ques)->first();
				$all_data['question']=$ques->question;
				$all_data['day']=$users_datas['day'];
				//$all_data['created_at']=$users_datas['updatedAt'];
				$convert_date=$users_datas['updatedAt']/1000;
				
				$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);
				//$all_data['question_type']=$ques->questionType;
				if(is_array($ques->questionType)){
					$all_data['question_type']=implode(',',$ques->questionType);
				}
				else{
					$all_data['question_type']=$ques->questionType;
				}
				
				$all_data['userId']=$users_info->userId;
				$all_data['type']='Q&A';
				//$all_data['answer']=$kk['answer'];
				
				$all_data['threat_stimuli']="None";
				$all_data['neutral_stimuli']="None";
				$all_data['threat_position']="None";
				$all_data['probe_position']="None";
				$all_data['probe']="None";
				$all_data['probe_selected']="None";
				if(is_array($kk['answer']))
				{
					$all_data['response']=implode(',',$kk['answer']);
				}
				else{
					$all_data['response']=$kk['answer'];

				}
				$all_data['timeTakenToAnswer']="None";
				}
				else
				{
			    $word_id=$kk['stimuli'];	
				$_word = new MongoId($word_id);
				$word=Word::where('_id',$_word)->first();
				if(!empty($word))
				{
					$word_face=$word->word_face;
					if($word_face=='word'){
					$all_data['question']="None";
					$all_data['question_type']="None";
					$all_data['answer']="None";

					$all_data['threat_stimuli']=$word->threat_word;
					$all_data['neutral_stimuli']=$word->neutral_word;
					$all_data['threat_position']=$word->threat_position;
					$all_data['probe_position']=$word->probe_position;
					//$all_data['created_at']=$users_datas['updatedAt'];
					$convert_date=$users_datas['updatedAt']/1000;
					$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);

					$all_data['probe']=$word->probe;
					$all_data['day']=$users_datas['day'];

					$all_data['timeTakenToAnswer']=$kk['timeTakenToAnswer']*0.001;
					$all_data['probe_selected']=$kk['answer'];
					if($word->probe==$kk['answer']){
					  $all_data['response']="Success";
					}
					else{
						$all_data['response']="Failure";
					}
					
					$all_data['userId']=$users_info->userId;
					$all_data['type']='Words';
					}
					else{
					$all_data['question']="None";
					$all_data['question_type']="None";
					$all_data['answer']="None";

					$all_data['threat_stimuli']=$word->threat_faces;
					$all_data['neutral_stimuli']=$word->neutral_faces;
					$all_data['threat_position']=$word->threat_position;
					$all_data['probe_position']=$word->probe_position;
					//$all_data['created_at']=$users_datas['updatedAt'];
					$convert_date=$users_datas['updatedAt']/1000;
					$all_data['created_at']=date("d-m-Y  H:i:s",$convert_date);

					$all_data['probe']=$word->probe;
					$all_data['day']=$users_datas['day'];

					$all_data['timeTakenToAnswer']=$kk['timeTakenToAnswer']*0.001;
					$all_data['probe_selected']=$kk['answer'];
					if($word->probe==$kk['answer']){
					  $all_data['response']="Success";
					}
					else{
						$all_data['response']="Failure";
					}
					
					$all_data['userId']=$users_info->userId;
					$all_data['type']='Faces';
						
					}

				}
				   // echo "<pre>";
				   // print_r($all_data);die();
					}
					array_push($t,$all_data);
			}
				
		} 
		
		$allArray[$dataUser] = $t;
				}
			
				// Get all files in a directory
				
				$dir=public_path()."/myFiles/";				
				$file = new Filesystem;
                $file->cleanDirectory($dir);
				$count_row=1;
				$file_path=public_path()."/myFiles/";
		        foreach($allArray as $key => $rowID) {
		        // if(!empty($rowID)){
		            //$filename = public_path()."/myFiles/user_report_".$key.".csv";
		            $filename = public_path()."/myFiles/".$key.".csv";
		            $handle = fopen($filename, 'w+');
		            fputcsv($handle, array('PID','Day','Type','Question','ThreatStimuli','NeutralStimuli','Probe','ThreatPosition','ProbePosition','ProbeSelected','Response','ResponseTime', 'created_at'));

		            foreach($rowID as $i=>$row) {
		                fputcsv($handle, array($row['userId'],$row['day'],$row['type'],$row['question'], $row['threat_stimuli'], $row['neutral_stimuli'] ,$row['probe'],$row['threat_position'],  $row['probe_position'],$row['probe_selected'],$row['response'],$row['timeTakenToAnswer'],$row['created_at']));
		            }

					fclose($handle);
						$headers = array(
							'Content-Type' => 'text/csv',
						);
						$count_row++;
					// }
				}
				
				$zip = new ZipArchive;
				$current = time(); 
				$fileName ="allUsers".$current.".zip";	
				//$fileName = 'myNewFile.zip';		   
				if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
				{
					$files = File::files(public_path('myFiles'));
		   
					foreach ($files as $key => $value) {
						$relativeNameInZipFile = basename($value);
						$zip->addFile($value, $relativeNameInZipFile);
					}
					 
					$zip->close();
				}
				return response()->download(public_path($fileName));
			
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
    public function usersData()
    {
     $data=User::select('userId','options','createdAt')->get();
	 $dataArray=Word::get()->toArray();
     $allArray = array();
     foreach ($data as $val_data) {
     foreach ($dataArray as $key => $value) {

            if(!empty($value['userId'])){

              if($value['userId'] == $val_data['userId']){
                  $val_data['data_id'] = $value['_id'];
				  $study=Study::where('_id','=',$users->study)->first();
                  $val_data['studyId']=$study->studyId;
                  $val_data['study_id']=$study->studyId;
                  $val_data['userId']=$study->studyId;
                  $val_data['pin']=$value['pin'];
                  $val_data['options']=$study->studyId;
                  $val_data['studyy_idd']=$study->_id;

              }

            }else{

              if($value['threat_word'] == $val_data['threat_word']){
                  $val_data['data_id'] = $value['_id'];
              }
            }
        }
        $allArray[] = $val_data;
     }
	 
	 // foreach($user as $users){
                // $study=Study::where('_id','=',$users->study)->first();
				// if(!empty($study))
				// {
                // $users_info[]=[
                // 'studyId'=>$study->studyId,
                // 'study_id'=>$users->study,
                // 'userId'=>$users->userId,
                // 'pin'=>$users->pin,

                // 'userType'=>$users->userType,
                // 'options'=>$users->options,
                // '_id'=>$users->_id,
                // ];
				// }
            // }
	  return DataTables::of($data)
     ->make(true);
    }
}
