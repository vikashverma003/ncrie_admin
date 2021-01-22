@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
   <div class="row">
   <div class="col-md-10 offset-md-1 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 @if (session('er_status'))
                  <div class="alert alert-danger">{!! session('er_status') !!}</div>
                @endif
                @if (session('su_status'))
                  <div class="alert alert-success">{!! session('su_status') !!}</div>
                @endif
                  <h4 class="card-title">Add Words Or Faces</h4>
                  
                <form class="forms-sample" method="post" action="{{route('words.store')}}" enctype="multipart/form-data" id="create_company">
                  @csrf
				  
				  <div class="form-group ">
                       <label class="control-label">Do you want to select Words or Faces?</label>
					     <div class="col-md-6">
                        <select class="form-control"  name="word_face" id="word_face" required>
                        <option value="">Select Faces or Words</option> 
                         <option value="word">Words</option>
                         <option value="face">Faces</option>
                        </select>
						</div>
                        </div>
				 
                      <div class="form-group" >
                       <label class="control-label">Select Conditions</label>
                        <div class="col-md-6" id="hide_word">
                        <select class="form-control"  name="condition[]" id="condition" multiple>
                        <!-- <option value="1">Select Condition</option>-->
                        @foreach($condition as $value)
                         <option value="{{$value}}">{{$value}}</option>
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
                         <option value="{{$value}}">{{$value}}</option>
                          @endforeach
                        </select>
                         </div>
                      </div>
					  
                      <!--<div class="form-group ">
                       <label class="control-label">Select Conditions</label>
                        <div class="col-md-6">
                        <select class="form-control"  name="condition[]" id="condition" multiple required>
                        @foreach($condition as $value)
                         <option value="{{$value}}">{{$value}}</option>
                          @endforeach
                        </select>
                         </div>
                      </div>-->
					  
					  <div class="form-group ">
                       <label class="control-label">Select  Type</label>
					     <div class="col-md-6">
                        <select class="form-control"  name="type" id="type" required>
                       <option value="">Select Type</option>   
                         <option value="assessment">assessment</option>
                         <option value="training">training</option>
                        </select>
						</div>
                        </div>
						
						 <div class="form-group cycle1">
                       <label class="control-label">Select training cycle</label>
                        <div class="col-md-6" id="cycle1">
                        <select class="form-control"  name="training_cycle[]" id="training_cycle" multiple required>
                         <option value="1">1</option>
                         <option value="2">2</option>
						 <option value="3">3</option>
                         <option value="4">4</option>
                         <option value="5">5</option>
                         <option value="6">6</option>
                        </select>
                         </div>
                      </div>
					  <!-- <div class="form-group cycle2" style="display:none;">
                       <label class="control-label">Select training cycle</label>
                        <div class="col-md-6" id="cycle2">
                        <select class="form-control"  name="training_cycle[]" id="training_cycle2" multiple>
						 <option value="">Select cycle</option>   
                         <option value="1">1</option>
						 <option value="3">3</option>
                         <option value="5">5</option>
                        </select>
                         </div>
                      </div>
					   <div class="form-group cycle3" style="display:none;">
                       <label class="control-label">Select training cycle</label>
                        <div class="col-md-6" id="cycle3">
                        <select class="form-control"  name="training_cycle[]" id="training_cycle3" multiple>
						<option value="">Select cycle</option>   
                         <option value="2">2</option>
                         <option value="4">4</option>
                         <option value="6">6</option>
                        </select>
                         </div>
                      </div>-->
					  <div class="check_words">
					  
					  </div>
					  <br/><br/>
                   <!-- <div class="words" style="display:none;">
                    <div class="form-group">
                      <div class="row">
                            <div class="col-md-6" id="threat_word">
                      <label class="control-label" for="name"> Threat Word </label>
                      <input type="text" name="threat_word" class="form-control" id="threat_word" placeholder="threat_word"
                         />
                    </div>
                  </div></div>
				 
                    
                    <div class="form-group">
                      <div class="row">
                            <div class="col-md-6" id="neutral_word">
                      <label class="control-label" for="training_trial_count"> Neutral Word
                      </label>
                      <input type="neutral_word" name="neutral_word" class="form-control" id="neutral_word" placeholder="neutral_word"
                        />
                    </div>
                  </div></div>-->
				 
					  
                   <!--<div class="form-group ">
                       <label class="control-label">Neutral Word Position</label>
                        <div class="col-md-6">
                        <select class="form-control"  name="neutral_word_po" id="neutral_word_po">
                         <option value="top">Top</option>
                         <option value="bottom">Bottom</option>
                        </select>
                         </div>
                      </div> -->
                <!--</div>-->

              <!-- <div class="faces" style="display:none;">
                    <div class="form-group">
                      <div class="row">
                            <div class="col-md-6" id="threat_face">
                      <label class="control-label" for="name"> Threat Face </label>
                      <input type="file" name="threat_face" class="form-control" 
                         />
                    </div>
                  </div></div>
                    <div class="form-group">
                      <div class="row">
                            <div class="col-md-6" id="neutral_face">
                      <label class="control-label" for="training_trial_count"> Neutral Face
                      </label>
                      <input type="file" name="neutral_face" class="form-control"
                        />
                    </div>
                  </div></div>
				 
                </div>-->
                    
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
  $("#word_face").on('change',function(){
  var word_face=$(this).val();
  if(word_face=='word'){
	     // $(".check_words").append("<input type="text">.");
		$('.check_words').empty();
		$('<div class="col-lg-6"><strong>Threat Word</strong><input type="text" name="threat_word" class="form-control"  placeholder="threat_word" required></div>').appendTo('.check_words');
		$('<div class="col-lg-6"><strong>Neutral Word</strong><input type="text" name="neutral_word" class="form-control"  placeholder="neutral_word" required></div>').appendTo('.check_words');
		// $('<input type="text">').appendTo('.check_words');


	    //alert(word_face);
   // $('#follow_up_day'). prop("disabled", true);
   	  $("#hide_face").children().prop('disabled',true);
   	  $("#hide_word").children().prop('disabled',false);  
	  $('.words').show();
      $('.sub-btn').show();
	  $('.faces').hide();
	  
  }else{
	  		$('.check_words').empty();
	  	  $('<div class="col-lg-6"><strong>Threat Face</strong><input type="file" name="threat_face" class="form-control" placeholder="threat_face" required></div>').appendTo('.check_words');
	  	  $('<div class="col-lg-6"><strong>Neutral Face</strong><input type="file" name="neutral_face" class="form-control" placeholder="neutral_face" required></div>').appendTo('.check_words');
	       $("#hide_word").children().prop('disabled',true);  
	       $("#hide_face").children().prop('disabled',false);
		   $('.words').hide();
           $('.sub-btn').show();
		   $('.faces').show();
	
  }
	
  });
});

</script>
<!--<script>
$(document).ready(function(){
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
</script>-->

  
  @endsection