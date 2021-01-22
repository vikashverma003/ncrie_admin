<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Word;
use DataTables;
use App\Models\Study;
use App\Models\Pattern;
use URL;
use Image;
use App\Models\Questions;
use \MongoDB\BSON\ObjectID as MongoId;
use App\Models\User;
use Response;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $word_obj;
    private $pattern_obj;
    public function __construct(Word $word,Pattern $pattern_obj){
        $this->word_obj=$word;
        $this->pattern_obj=$pattern_obj;
    }
    public function index()
    {
        $words=Word::paginate(8);
        $words_count=Word::get()->count();
		if($words_count>0){
			return view('admin.words.index3',compact('words'));
		}
		else{
			return redirect('/admin/words/create');
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       /* $condition=[
            'ABM'=> "ABM_WITH_WORDS",
            'ABMF'=> "ABM_WITH_FACES",
            'ACT'=> "ACT_WITH_WORDS",
            'ACTF'=>"ACT_WITH_FACES",
            'PLACEBO'=>"PLACEBO_WITH_WORDS",
            'PLACEBOF'=> "PLACEBO_WITH_FACES",
            'QUESTIONS'=> "QUESTIONS"
          ];*/
		  $condition=[
            'ABM'=> "ABM_WITH_WORDS",
            'ACT'=> "ACT_WITH_WORDS",
            'PLACEBO'=>"PLACEBO_WITH_WORDS",
           // 'QUESTIONS'=> "QUESTIONS"
          ];
		  $condition_face=[
            'ABMF'=> "ABM_WITH_FACES",
            'ACTF'=>"ACT_WITH_FACES",
            'PLACEBOF'=> "PLACEBO_WITH_FACES",
          ];

        return view('admin.words.create1',compact('condition','condition_face'));
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
           // 'study'=>'required',
            'condition'=>'required',
           // 'probe'=>'required'
        ]);
            $data=$request->all();
			//echo "<pre>";print_r($data);die();
		  // $url= URL::to('/');
		  $url="https://ncire.imgix.net";
			 $path="threat_face";
			  $imagePath_threat=null;
			  $thumbnail_threat=null;
			  $threat_face_name="";
            if($file = $request->hasFile('threat_face')) {
                $file = $request->file('threat_face');
                $extension = $file->getClientOriginalName();
                $thumb = Image::make($file->getRealPath())->resize(113, 113, function ($constraint) {
                    $constraint->aspectRatio(); //maintain image ratio
                });
                $destinationPath = public_path('/admin/images/faces/' . $path);
				$imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
				$threat_face_name=$imagename;
                $file->move($destinationPath, $imagename);
                $thumb->save($destinationPath.'/thumb_'.$imagename);
                // $threatImage['imagePath_threat'] = $url.'/admin/images/faces/'. $path . '/' . $extension;
                // $threatImage['thumbnail_threat'] = $url.'/admin/images/faces/'. $path . '/thumb_' . $extension;
				 //$imagePath_threat = $url.'/admin/images/faces/'. $path.'/'.$extension;
                 //$thumbnail_threat = $url.'/admin/images/faces/'. $path.'/thumb_'.$extension;
				 // $imagePath_threat = $url.'/threat_face/'.$imagename;
                 //$thumbnail_threat = $url.'/threat_face/thumb_'.$imagename;
				
				$imagePath_threat = $url.'/threat_face/'.$imagename;
                 $thumbnail_threat = $url.'/threat_face/'.$imagename;
				
				
            }
			 $path1="neutral_face";
			 $imagePath_neutral=null;
			 $thumbnail_neutral=null;
			 $neutral_face_name="";
			
            if($file = $request->hasFile('neutral_face')) {
                $file = $request->file('neutral_face');
                $extension = $file->getClientOriginalName();
                $thumb = Image::make($file->getRealPath())->resize(113, 113, function ($constraint) {
                    $constraint->aspectRatio(); //maintain image ratio
                });
                $destinationPath = public_path('/admin/images/faces/' . $path1);
                $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
				$neutral_face_name=$imagename;
				$file->move($destinationPath, $imagename);
                $thumb->save($destinationPath.'/thumb_'.$imagename);
				// $neutralImage['imagePath_neutral'] = $url.'/admin/images/faces/'. $path1. '/' . $extension;
                // $neutralImage['thumbnail_neutral'] = $url.'/admin/images/faces/'. $path1. '/thumb_' . $extension;
				
				//$imagePath_neutral = $url.'/admin/images/faces/'. $path1.'/'.$extension;
                //$thumbnail_neutral = $url.'/admin/images/faces/'. $path1.'/thumb_'.$extension;
				
//$imagePath_neutral = $url.'/admin/images/faces/'. $path1.'/'.$imagename;
				// $imagePath_neutral = $url.'/admin/images/faces/'. $path1.'/'.$imagename;
                // $thumbnail_neutral = $url.'/admin/images/faces/'. $path1.'/thumb_'.$imagename;
				//$imagePath_neutral = $url.'/neutral_face/'.$imagename;
                //$thumbnail_neutral = $url.'/neutral_face/thumb_'.$imagename;
			   
			   $imagePath_neutral = $url.'/neutral_face/'.$imagename;
                $thumbnail_neutral = $url.'/neutral_face/'.$imagename;
				
				
				
				
            }
				
					
				$data['probe']="E";
				$data['threat_position']="top";
				$data['probe_position']="bottom";		
                $addData = [
                           'threat_word' =>$data['word_face']=='word'?$data['threat_word']:null,
                           'neutral_word' =>$data['word_face']=='word'?$data['neutral_word']:null,
                           'condition' => $data['condition'],
						   'word_face' =>$data['word_face'],
						    'threat_faces_original' => $imagePath_threat,  
						    'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],
                           'probe' => $data['probe'],
                           'threat_position' => $data['threat_position'],
                           'probe_position' => $data['probe_position'],
						   'isThreatTop'=>true,
						   'isProbeE'=>true,
						   'threat_face_name' => $threat_face_name!=''?$threat_face_name:null,
                           'neutral_face_name' => $neutral_face_name!=''?$neutral_face_name:null,

                        ];
				//$user_info1=$this->word_obj->createWord($addDataWord);              
                $user_info=$this->word_obj->createWord($addData);
		        $addData1 = [
                          'threat_word' =>$data['word_face']=='word'?$data['threat_word']:null,
                           'neutral_word' =>$data['word_face']=='word'?$data['neutral_word']:null,
                           'condition' => $data['condition'],
						   'word_face' =>$data['word_face'],
						    'threat_faces_original' => $imagePath_threat,  
						    'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],
                           'probe' => 'F',
                           'threat_position' =>'bottom',
                           'probe_position' => 'top',
						   'isThreatTop'=>false,
						   'isProbeE'=>false,
						     'threat_face_name' => $threat_face_name!=''?$threat_face_name:null,
                           'neutral_face_name' => $neutral_face_name!=''?$neutral_face_name:null,

                        ];
		        $user_info1=$this->word_obj->createWord($addData1);
		        $addData2 = [
                           'threat_word' =>$data['word_face']=='word'?$data['threat_word']:null,
                           'neutral_word' =>$data['word_face']=='word'?$data['neutral_word']:null,
                           'condition' => $data['condition'],
						   'word_face' =>$data['word_face'],
						    'threat_faces_original' => $imagePath_threat,  
						    'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],
                           'probe' => 'E',
                           'threat_position' =>'bottom',
                           'probe_position' => 'top',
						   'isThreatTop'=>false,
						   	'isProbeE'=>true,

						      'threat_face_name' => $threat_face_name!=''?$threat_face_name:null,
                           'neutral_face_name' => $neutral_face_name!=''?$neutral_face_name:null,
                        ];
			    $user_info2=$this->word_obj->createWord($addData2);	
                $addData3 = [
                            'threat_word' =>$data['word_face']=='word'?$data['threat_word']:null,
                           'neutral_word' =>$data['word_face']=='word'?$data['neutral_word']:null,
                           'condition' => $data['condition'],
						   'word_face' =>$data['word_face'],
						    'threat_faces_original' => $imagePath_threat,  
						    'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],
                           'probe' => 'F',
                           'threat_position' =>'top',
                           'probe_position' => 'bottom',
						   'isThreatTop'=>true,
						   	'isProbeE'=>false,
						   'threat_face_name' => $threat_face_name!=''?$threat_face_name:null,
                           'neutral_face_name' => $neutral_face_name!=''?$neutral_face_name:null,
                        ];	
				$user_info3=$this->word_obj->createWord($addData3);
				if ($user_info3) {
						return redirect('admin/words')->with("su_status", "Data has been added successfully");                  
						} 
				else {
						return Redirect::back()->with('er_status', 'No user  added!');
					}
				//}
				// else{
					// return redirect('admin/words')->with("er_status", "This pair of word already exist. Please enter another pair of word");                  
				// }
    }

    public function upload_words(Request $request){
        //echo 232;
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt' 
        ]);

        if ($request->hasFile('csv_file')) {
                        $file = request()->file('csv_file');
                        $ext=$file->getClientOriginalExtension();
                        $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $file->move('admin/images/csv', $imagename);
                        }

                        $fileD = fopen(public_path().'/admin/images/csv/'.$imagename,"r");
                        $column=fgetcsv($fileD);
                        while(!feof($fileD)){
                         $rowData[]=fgetcsv($fileD);
                        }
                        
                   // echo "<pre>";     
                   // print_r($rowData);
                    $arrNewSku = array();
                    $con=["ACT_WITH_WORDS"];
                    $incI = 0;
                    foreach($rowData AS $arrKey => $arrData){
                        //$arrNewSku[$incI]['sku_id'] = $arrKey;
                        //$arrNewSku[$incI]['threat_word'] = $arrData[0];
                        //$arrNewSku[$incI]['neutral_word'] = $arrData[1];
                        if(!empty($arrData[1]))
                        {
                       $word=new Word;
                       $word->threat_word= $arrData[0];
                       $word->neutral_word= $arrData[1];
                       $word->condition= $con;
                       $word->type= 'assessment';
                       $word->trainingCycle= 2;
                       $word->threat_position='top';
                       $word->probe='E';
                       $word->probe_position='top';
                       $word->save();
                       }
                        $incI++;
                    }
                    return redirect('admin/words')->with("su_status", "Word has been added successfully");                  
                    //Convert array to json form...
                    // $encodedSku = json_encode($arrNewSku);
                    // print('<pre>');
                    // print_r($encodedSku);
                    // print('</pre>');

    }


    public function match_studies(Request $request){
        $condition=$request->search;
        $study=Study::where('condition','=',$condition)->get();
        // $studies=Study::where('condition','=',$condition)->get();
		// $study=[];
		// foreach($studies as $studyy)
		// {
		    // $_iddd = new MongoId($studyy['_id']);
			// $question=Questions::where('study',$_iddd)->first();
				// if(!empty($question))
				// {
					// $study['studyId']=$studyy->studyId;
					// $study['_id']=$studyy->_id;
				// }

		// }
		
        return response()->json(['status'=>true,'data'=>$study, 'message'=>' successfully'], 200);
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
		echo $id;
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

     public function wordData()
   {
	   //	   $_iddd = new MongoId($data['_id'])'
	   // $data=Word::select('threat_word','neutral_word','createdAt','threat_faces_original','neutral_faces_original')->groupBy(['threat_word','threat_faces_original'])->get();

     //    $_iddd = new MongoId($data['_id'])'
     $data=Word::select('threat_word','neutral_word','createdAt','threat_faces_original','neutral_faces_original')->groupBy(['threat_word','threat_faces_original'])->get();
     $dataArray=Word::get()->toArray();

     $allArray = array();
     foreach ($data as $val_data) {

     foreach ($dataArray as $key => $value) {

            if(!empty($value['threat_faces_original'])){

              if($value['threat_faces_original'] == $val_data['threat_faces_original']){
                  $val_data['data_id'] = $value['_id'];
              }

            }else{

              if($value['threat_word'] == $val_data['threat_word']){
                  $val_data['data_id'] = $value['_id'];
              }
            }
        }
        $allArray[] = $val_data;
     }


	   return DataTables::of($allArray)
	  ->make(true);
   }
   
   public function edit_words($id){
	   
		$words=Word::where('_id', $id)->first();

		 $condition=[
            'ABM'=> "ABM_WITH_WORDS",
            'ACT'=> "ACT_WITH_WORDS",
            'PLACEBO'=>"PLACEBO_WITH_WORDS",
            'QUESTIONS'=> "QUESTIONS"
          ];
		  $condition_face=[
            'ABMF'=> "ABM_WITH_FACES",
            'ACTF'=>"ACT_WITH_FACES",
            'PLACEBOF'=> "PLACEBO_WITH_FACES",
          ];
		return view('admin.words.edit',compact('words','condition_face','condition'));
	   }


  public function update_words(Request $request){
    // $data = Word::get()->toArray();
  // echo '<pre>';
  // print_r($request->input('pre_threat_face'));
  // exit;
            $request->validate([
               // 'study'=>'required',
                'condition'=>'required',
               // 'probe'=>'required'
            ]);

            $data=$request->all();
    
            $url= URL::to('/');
            $path="threat_face";
            $imagePath_threat=$request->input('pre_threat_face');
            $thumbnail_threat=$request->input('pre_threat_face_thumb');
            if($file = $request->hasFile('threat_face')) {
                $file = $request->file('threat_face');
                $extension = $file->getClientOriginalName();
                $thumb = Image::make($file->getRealPath())->resize(100,100, function ($constraint) {
                    $constraint->aspectRatio(); //maintain image ratio
                });
                $destinationPath = public_path('/admin/images/faces/' . $path);
                $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

                $file->move($destinationPath, $imagename);
                $thumb->save($destinationPath.'/thumb_'.$imagename);
                $imagePath_threat = $url.'/admin/images/faces/'. $path.'/'.$imagename;
                $thumbnail_threat = $url.'/admin/images/faces/'. $path.'/thumb_'.$imagename;
        
            }
           $path1="neutral_face";
           $imagePath_neutral=$request->input('pre_neutral_face');
           $thumbnail_neutral=$request->input('pre_neutral_face_thumb');
            if($file = $request->hasFile('neutral_face')) {
                $file = $request->file('neutral_face');
                $extension = $file->getClientOriginalName();
                $thumb = Image::make($file->getRealPath())->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio(); //maintain image ratio
                });
                $destinationPath = public_path('/admin/images/faces/' . $path1);
                $imagename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

                $file->move($destinationPath, $imagename);
                        $thumb->save($destinationPath.'/thumb_'.$imagename);
                // $neutralImage['imagePath_neutral'] = $url.'/admin/images/faces/'. $path1. '/' . $extension;
                        // $neutralImage['thumbnail_neutral'] = $url.'/admin/images/faces/'. $path1. '/thumb_' . $extension;
                
                //$imagePath_neutral = $url.'/admin/images/faces/'. $path1.'/'.$extension;
                        //$thumbnail_neutral = $url.'/admin/images/faces/'. $path1.'/thumb_'.$extension;
                
                $imagePath_neutral = $url.'/admin/images/faces/'. $path1.'/'.$imagename;
                $thumbnail_neutral = $url.'/admin/images/faces/'. $path1.'/thumb_'.$imagename;
            }
			
			 $addData = [
                           'threat_word' =>$data['threat_word'],
                           'neutral_word' => $data['neutral_word'],
                           'condition' => $data['condition'],
                           'word_face' =>$data['word_face'],
                            'threat_faces_original' => $imagePath_threat,  
                            'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],                           
                        ];
			    $words=Word::where('_id',$data['id'])->update($addData);
			    return redirect('admin/words')->with("su_status", "Word has been updated successfully");                  
                /*$data['probe']="E";
                $data['threat_position']="top";
                $data['probe_position']="bottom";   
                $addData = [
                           'threat_word' =>$data['threat_word'],
                           'neutral_word' => $data['neutral_word'],
                           'condition' => $data['condition'],
                           'word_face' =>$data['word_face'],
                            'threat_faces_original' => $imagePath_threat,  
                            'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],
                           
                           'isThreatTop'=>true,
                           'old_id' => $data['pre_word'],
                           'old_check' => $data['pre_threat_face'],
                        ];
                        
            $user_info=$this->word_obj->updateWord($addData);
            $addData1 = [
                           'threat_word' =>$data['threat_word'],
                           'neutral_word' => $data['neutral_word'],
                           'condition' => $data['condition'],
                           'word_face' =>$data['word_face'],
                            'threat_faces_original' => $imagePath_threat,  
                            'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],
                          
                            'isThreatTop'=>false,
                           'old_id' => $data['pre_word'],
                           'old_check' => $data['pre_threat_face'],

                        ];
               $user_info1=$this->word_obj->updateWord($addData1);
               $addData2 = [
                           'threat_word' =>$data['threat_word'],
                           'neutral_word' => $data['neutral_word'],
                           'condition' => $data['condition'],
                           'word_face' =>$data['word_face'],
                            'threat_faces_original' => $imagePath_threat,  
                            'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],
                            'isThreatTop'=>false,
                           'old_id' => $data['pre_word'],
                           'old_check' => $data['pre_threat_face'],
                        ];
            $user_info2=$this->word_obj->updateWord($addData2); 
            $addData3 = [
                           'threat_word' =>$data['threat_word'],
                           'neutral_word' => $data['neutral_word'],
                           'condition' => $data['condition'],
                           'word_face' =>$data['word_face'],
                           // 'threat_faces' => $threatImage,  
                           // 'neutral_faces' =>  $neutralImage,
                            'threat_faces_original' => $imagePath_threat,  
                            'threat_faces_thumbnail' => $thumbnail_threat,  
                            'neutral_faces_original' =>  $imagePath_neutral,
                            'neutral_faces_thumbnail' =>  $thumbnail_neutral,
                            'type' => $data['type'],
                           'training_cycle' => $data['training_cycle'],                         
                            'isThreatTop'=>true,
                           'old_id' => $data['pre_word'],
                           'old_check' => $data['pre_threat_face'],
                        ];  
        
        $user_info3=$this->word_obj->updateWord($addData3);*/
       
  }
  
   public function delete_words(Request $request,$id){
	  //echo $id;
	  $words=Word::where('_id',$id)->first();
		if(!empty($words))
		{
		$word_face=$words->word_face;
		if($word_face=='word'){
			$threat_word=$words->threat_word;
			$neutral_word=$words->neutral_word;
		   $words=Word::where('threat_word',$threat_word)->where('neutral_word',$neutral_word)->delete();

		}
		else{
			$threat_face=$words->threat_faces;
			$neutral_face=$words->neutral_faces;
		    $faces=Word::where('threat_faces',$threat_face)->where('neutral_faces',$neutral_face)->delete();
		}
		}
	
	return redirect('admin/words')->with("su_status", "Data has been deleted successfully");                  

	 
  }
  
  public function download_sample_file(Request $request){
		   $table = User::get();
            $filename = "tweets.csv";
            $handle = fopen($filename, 'w+');
            fputcsv($handle, array('userType', 'userId', 'study', 'pin'));

            foreach($table as $row) {
                fputcsv($handle, array($row['userType'], $row['userId'], $row['study'], $row['pin']));
            }
            fclose($handle);
            $headers = array(
                'Content-Type' => 'text/csv',
            );
            return Response::download($filename, 'SampleFile.csv', $headers);

	  
  }
   
   
   
}
