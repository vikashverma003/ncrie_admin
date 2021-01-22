<?php 
// echo '<pre>';
// print_r($words);
// exit;

?>

@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
   <div class="row">
   <div class="col-md-10 offset-md-1 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                @if (\Session::has('error'))
                  <div class="alert alert-danger">
                     {!! \Session::get('error') !!}
                  </div>
                @endif
                  <h4 class="card-title">Edit Words Or Faces</h4>
                  
                <form class="forms-sample" method="post" action="{{url('admin/update_words')}}" enctype="multipart/form-data" id="create_company">
                  @csrf
				  
				  <div class="form-group ">
                       <label class="control-label">Do you want to select Word or Faces?</label>
					     <div class="col-md-6">
                        <select class="form-control"  name="word_face" id="word_face" required>
                        <option value="">Select question or word</option> 
                         <option value="word"<?php if($words->word_face =='word') echo "selected";?>>Word</option>
                         <option value="face"<?php if($words->word_face =='face') echo "selected";?>>Faces</option>
                        </select>
						</div>
                        </div>
				    <input type="hidden" name="id" value="{{$words->_id}}" />
                      <div class="form-group" >
                       <label class="control-label">Select Conditions</label>
                        <div class="col-md-6" id="hide_word">
                        <select class="form-control"  name="condition[]" id="condition" multiple>
                        @foreach($condition as $value)
                         <option @if(in_array($value, $words['condition'])) selected="selected" @endif  value="{{$value}}">{{$value}}</option>
                          @endforeach
                        </select>
                         </div>
                      </div>
					  <div class="form-group ">
                       <label class="control-label">Select Conditions</label>
                        <div class="col-md-6" id="hide_face">
                        <select class="form-control"  name="condition[]" id="condition" multiple>
                        <!-- <option value="1">Select Condition</option>-->
                        @foreach($condition_face as $value)
                         <option @if(in_array($value, $words['condition'])) selected="selected" @endif value="{{$value}}">{{$value}}</option>
                          @endforeach
                        </select>
                         </div>
                      </div>
					  
					  
					  <div class="form-group ">
                       <label class="control-label">Select  Type</label>
					     <div class="col-md-6">
                        <select class="form-control"  name="type" id="type" required>
                       <option value="">Select Type</option>   
                         <option value="assessment"<?php if($words->type =='assessment') echo "selected";?>>assessment</option>
                         <option value="training"<?php if($words->type =='training') echo "selected";?>>training</option>
                        </select>
						</div>
                        </div>
						
						 <div class="form-group cycle1" style="display:none;">
                       <label class="control-label">Select training cycle</label>
                        <div class="col-md-6" id="cycle1">
                        <select class="form-control"  name="training_cycle[]" id="training_cycle" multiple >
                         <option @if(in_array('1', $words['trainingCycle'])) selected="selected" @endif value="1">1</option>
                         <option @if(in_array('2', $words['trainingCycle'])) selected="selected" @endif value="2">2</option>
						             <option @if(in_array('3', $words['trainingCycle'])) selected="selected" @endif value="3">3</option>
                         <option @if(in_array('4', $words['trainingCycle'])) selected="selected" @endif value="4">4</option>
                         <option @if(in_array('5', $words['trainingCycle'])) selected="selected" @endif value="5">5</option>
                         <option @if(in_array('6', $words['trainingCycle'])) selected="selected" @endif value="6">6</option>
                        </select>
                         </div>
                      </div>
					   <div class="form-group cycle2" style="display:none;">
                       <label class="control-label">Select training cycle</label>
                        <div class="col-md-6" id="cycle2">
                        <select class="form-control"  name="training_cycle[]" id="training_cycle2" multiple>
						            <option value="">Select cycle</option>   
                        <option @if(in_array('1', $words['trainingCycle'])) selected="selected" @endif value="1">1</option>
						            <option @if(in_array('3', $words['trainingCycle'])) selected="selected" @endif value="3">3</option>
                        <option @if(in_array('5', $words['trainingCycle'])) selected="selected" @endif value="5">5</option>
                        </select>
                         </div>
                      </div>
					   <div class="form-group cycle3" style="display:none;">
                       <label class="control-label">Select training cycle</label>
                        <div class="col-md-6" id="cycle3">
                        <select class="form-control"  name="training_cycle[]" id="training_cycle3" multiple>
						             <option value="">Select cycle</option>   
                         <option @if(in_array('2', $words['trainingCycle'])) selected="selected" @endif value="2">2</option>
                         <option @if(in_array('4', $words['trainingCycle'])) selected="selected" @endif value="4">4</option>
                         <option @if(in_array('6', $words['trainingCycle'])) selected="selected" @endif value="6">6</option>
                        </select>
                         </div>
                      </div>
					  <!-- <div class="form-group ">
                       <label class="control-label">Probe</label>
                        <div class="col-md-6">
                        <select class="form-control"  name="probe" id="probe" required>
						 <option value="">Select Probe</option>
                         <option value="E">E</option>
                         <option value="F">F</option>
                        </select>
                         </div>
                      </div>
					  <div class="form-group ">
                       <label class="control-label">Probe Position</label>
                        <div class="col-md-6">
                        <select class="form-control"  name="probe_position" id="probe_position">
                         <option value="top">Top</option>
                         <option value="bottom">Bottom</option>
                        </select>
                         </div>
                      </div>
					  <div class="form-group ">
                       <label class="control-label">Threat Position</label>
                        <div class="col-md-6">
                        <select class="form-control"  name="threat_position" id="threat_position">
                         <option value="bottom">Bottom</option>
						 <option value="top">Top</option>
                        </select>
                         </div>
                      </div>-->
                      <!--<div class="form-group study-data" style="display:none;" required>
                       <label class="control-label">Select Study</label>
                       <div class="fetch-data"></div>
                       
                      </div>-->
                    <div class="words" style="display:none;">
                    <div class="form-group">
                      <div class="row">
                            <div class="col-md-6" id="threat_word">
                      <label class="control-label" for="name"> Threat Word </label>
                      <input type="text" name="threat_word" value="{{$words['threat_word']}}" class="form-control" id="threat_word" placeholder="threat_word"
                         />
                      <input type="hidden" name="pre_word" value="{{$words['threat_word'] ?? $words['threat_faces_original']}}"/>
                    </div>
                  </div></div>
				 
					  
                  <!--<div class="form-group ">
                       <label class="control-label">Threat Word Position</label>
                        <div class="col-md-6">
                        <select class="form-control"  name="threat_word_po" id="threat_word_po">
                         <option value="top">Top</option>
                         <option value="bottom">Bottom</option>
                        </select>
                         </div>
                      </div>-->
                    
                    <div class="form-group">
                      <div class="row">
                            <div class="col-md-6" id="neutral_word">
                      <label class="control-label" for="training_trial_count"> Neutral Word
                      </label>
                      <input type="neutral_word" name="neutral_word" value="{{$words['neutral_word']}}" class="form-control" id="neutral_word" placeholder="neutral_word"
                        />
                    </div>
                  </div></div>
				 
					  
                   <!--<div class="form-group ">
                       <label class="control-label">Neutral Word Position</label>
                        <div class="col-md-6">
                        <select class="form-control"  name="neutral_word_po" id="neutral_word_po">
                         <option value="top">Top</option>
                         <option value="bottom">Bottom</option>
                        </select>
                         </div>
                      </div> -->
                </div>

               <div class="faces" style="display:none;">
                    <div class="form-group">
                      <div class="row">
                            <div class="col-md-6" id="threat_face">
                      <label class="control-label" for="name"> Threat Face </label>
                      <input type="file" name="threat_face" class="form-control" 
                         />
                      <input type="hidden" name="pre_threat_face" value="{{$words['threat_faces_original']}}" />
                      <input type="hidden" name="pre_threat_face_thumb" value="{{$words['threat_faces_thumbnail']}}" />
                    </div>
                    <div class="col-md-6" id="">
                      @if(!empty($words['threat_faces_thumbnail']))
                        <img src="{{$words['threat_faces_thumbnail']}}" style="max-height: 100px !important;max-width: 93px !important;">
                      @endif
                    </div>
                  </div></div>
                    <div class="form-group">
                      <div class="row">
                            <div class="col-md-6" id="neutral_face">
                      <label class="control-label" for="training_trial_count"> Neutral Face
                      </label>
                      <input type="file" name="neutral_face" class="form-control"
                        />
                      <input type="hidden" name="pre_neutral_face" value="{{$words['neutral_faces_original']}}" />
                      <input type="hidden" name="pre_neutral_face_thumb" value="{{$words['neutral_faces_thumbnail']}}" />
                    </div>
                    <div class="col-md-6" id="">
                      @if(!empty($words['neutral_faces_thumbnail']))
                        <img src="{{$words['neutral_faces_thumbnail']}}" style="max-height: 100px !important;max-width: 93px !important;">
                      @endif
                    </div>
                  </div></div>
				 
                </div>
                    
                    <div class="form-group sub-btn" style="display:none;">

                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
   </div>
</div>

@endsection

@section('footerScript')
@parent

<!--<script>
$(document).ready(function() {

  $("#condition").on('change',function(){
  var conditions=$(this).val();
  if(conditions!='')
  {
          $('.study-data').show();

  }
  $("#condition option:selected").each(function () {
	  if($(this).val()=='ABM_WITH_WORDS'||$(this).val()=='ACT_WITH_WORDS'||$(this).val()=='PLACEBO_WITH_WORDS'||$(this).val()=='QUESTIONS')
	   {			   

            $('.words').show();
            $('.sub-btn').show();
		    $('.faces').hide();

	   }
	   else if($(this).val()=='ABM_WITH_FACES'||$(this).val()=='ACT_WITH_FACES'||$(this).val()=='PLACEBO_WITH_FACES'){
					   $('.words').hide();
		               $('.faces').show();
					   $('.sub-btn').show();
	   }
	   

     });
});

});

</script>-->
<script>
$(document).ready(function() {

  $("#condition").on('change',function(){
  var conditions=$(this).val();
  var op=''; 
  //alert(conditions);
   $.ajax({
    type : 'POST',
    url : '{{route("match_studies")}}',
    data:{"_token": "{{ csrf_token() }}",'search':conditions},
    success:function(data2){
      //console.log(data3);
       var data3=data2.data;
       op+='<div class="col-md-6">';
            op+='<select class="form-control"  name="study" id="study">';
            if(data3.length>0)
            {
            for(var i=0;i<data3.length;i++){
              op+='<option value='+data3[i]['_id']+'>'+data3[i]['studyId']+'</option>';
            }
          }
          else
          {
            op+='<option value="">'+"No Study Found for the selected Condition .Please Select Another Condition"+'</option>';

          }
             op+='</div>';
             $('.fetch-data').html(op); 
    }
    });
});

});

</script>

<script>

$(document).ready(function(){


  var word_face=$('#word_face').val();
  if(word_face=='word'){
      $("#hide_face").children().prop('disabled',true);
      $("#hide_word").children().prop('disabled',false);  
    $('.words').show();
      $('.sub-btn').show();
    $('.faces').hide();
  }else{
         $("#hide_word").children().prop('disabled',true);  
         $("#hide_face").children().prop('disabled',false);
       $('.words').hide();
           $('.sub-btn').show();
       $('.faces').show();
  }
  


  $("#word_face").on('change',function(){
  var word_face=$(this).val();
  if(word_face=='word'){
	    //alert(word_face);
   // $('#follow_up_day'). prop("disabled", true);
   	  $("#hide_face").children().prop('disabled',true);
   	  $("#hide_word").children().prop('disabled',false);  
	  $('.words').show();
      $('.sub-btn').show();
	  $('.faces').hide();
	  //$("#threat_face").children().prop('disabled',true);
	  //$("#neutral_face").children().prop('disabled',true);
	  //$("#threat_word").children().prop('disabled',false);
	  //$("#neutral_word").children().prop('disabled',false);
	  
  }else{
	       $("#hide_word").children().prop('disabled',true);  
	       $("#hide_face").children().prop('disabled',false);
		   $('.words').hide();
           $('.sub-btn').show();
		   $('.faces').show();
		   //$("#threat_word").children().prop('disabled',true);
	       //$("#neutral_word").children().prop('disabled',true);
		   //$("#threat_face").children().prop('disabled',false);
	       //$("#neutral_face").children().prop('disabled',false);
		  

  }
	
	
  });
});

</script>
<script>
$(document).ready(function(){

var type=$("#type").val();
    if(type=='assessment'){
         $('.cycle1').show();
         $('.cycle2').hide();
         $('.cycle3').hide();
         $("#cycle2").children().prop('disabled',true);
         $("#cycle3").children().prop('disabled',true);
         $("#cycle1").children().prop('disabled',false);
       
    }else{
      $('.cycle1').hide();
      $('.cycle2').show();
      $('.cycle3').show();
      $("#cycle1").children().prop('disabled',true);
      $("#cycle2").children().prop('disabled',false);
      $("#cycle3").children().prop('disabled',false);
      
     }

	$("#type").on('change',function(){
    var type=$(this).val();
    if(type=='assessment'){
	       $('.cycle1').show();
	  	   $('.cycle2').hide();
	       $('.cycle3').hide();
		   $("#cycle2").children().prop('disabled',true);
		   $("#cycle3").children().prop('disabled',true);
		   $("#cycle1").children().prop('disabled',false);
	     
    }
  else{
	  $('.cycle1').hide();
	  $('.cycle2').show();
	  $('.cycle3').show();
	  $("#cycle1").children().prop('disabled',true);
	  $("#cycle2").children().prop('disabled',false);
	  $("#cycle3").children().prop('disabled',false);
	  
   }
 });
});
</script>

<script>
$(document).ready(function(){

    var training_cycle2 =  $("#training_cycle2").val();

if(training_cycle2.indexOf('3') != -1 || training_cycle2.indexOf('1') != -1 || training_cycle2.indexOf('5') != -1){
    $("#cycle3").children().prop('disabled',true);
}else{
  $("#cycle3").children().prop('disabled',false);
}


	$("#training_cycle2").on('change',function(){
    var training_cycle2=$(this).val();
	//alert(type);
    if(training_cycle2=='1'||training_cycle2=='3'||training_cycle2=='5'){
	       // $('.cycle1').show();
	  	   // $('.cycle2').hide();
	       // $('.cycle3').hide();
		   //$("#cycle2").children().prop('disabled',true);
		    $("#cycle3").children().prop('disabled',true);
		   // $("#cycle1").children().prop('disabled',false);
	     
    }
  else{
	  // $('.cycle1').hide();
	  // $('.cycle2').show();
	  // $('.cycle3').show();
	  // $("#cycle1").children().prop('disabled',true);
	  // $("#cycle2").children().prop('disabled',false);
	   $("#cycle3").children().prop('disabled',false);
	  
    }
 });
});
</script>

<script>
$(document).ready(function(){

    var training_cycle3=$("#training_cycle3").val();

if(training_cycle3.indexOf('2') != -1 || training_cycle2.indexOf('4') != -1 || training_cycle2.indexOf('6') != -1){
    $("#cycle2").children().prop('disabled',true);
}else{
  $("#cycle2").children().prop('disabled',false);
}

	$("#training_cycle3").on('change',function(){
    var training_cycle3=$(this).val();
	//alert(type);
    if(training_cycle3=='2'||training_cycle3=='4'||training_cycle3=='6'){
	       // $('.cycle1').show();
	  	   // $('.cycle2').hide();
	       // $('.cycle3').hide();
		   $("#cycle2").children().prop('disabled',true);
		    //$("#cycle3").children().prop('disabled',true);
		   // $("#cycle1").children().prop('disabled',false);
	     
    }
  else{
	  // $('.cycle1').hide();
	  // $('.cycle2').show();
	  // $('.cycle3').show();
	  // $("#cycle1").children().prop('disabled',true);
	   $("#cycle2").children().prop('disabled',false);
	  // $("#cycle3").children().prop('disabled',false);
	  
    }
 });
});
</script>

  
  @endsection