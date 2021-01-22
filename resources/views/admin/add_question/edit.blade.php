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
                  <h4 class="card-title">Edit Questions</h4>
                  
                <form class="forms-sample" method="post" action="{{url('admin/update_question')}}/{{$qustion->_id}}/update" enctype="multipart/form-data" id="create_company">
                  @csrf
                
                      <div class="form-group">
                        <label class="control-label">Question</label>
						<div class="col-lg-6">           
						<textarea class="form-control"  name="question" id="question" rows="3"  required>{{$qustion->question}}</textarea>
				       </div>
                    </div>
                    <div class="form-group ">
                       <label class="control-label">Select Question Type</label>
					   <div class="col-lg-6">
                        <select class="form-control"  name="question_type[]" id="question_type" multiple required>
                        <!-- <option value="">Select An Question Type</option> -->
						@foreach($qustion->questionType as $qt=>$val)
                        <option value="questionnaire"<?php if($val =='questionnaire') echo "selected";?>>Pre Question</option>
                         <option value="assessment"<?php if($val =='assessment') echo "selected";?>>Assessment Question</option>
                         <option value="training"<?php if($val =='training') echo "selected"; ?>>Training Question</option>
                         <option value="last_day_questionnaire"<?php if($val =='last_day_questionnaire') echo "selected"; ?>>Post Questionnaire</option>
                         <option value="followUpQuestion"<?php if($val =='followUpQuestion') echo "selected"; ?>>Follow Up Question</option>
                          @endforeach
                        </select>
						</div>
                        </div>
                        <input type="hidden" name="study" value="{{$qustion->study}}">
						<div class="form-group follow-up">
                        <label class="control-label">Add Follow Up Day</label>
                       <div class="col-lg-6">
					   	@foreach($qustion->questionType as $qt=>$val)
						@if($val =='followUpQuestion')
                        <input class="form-control" type="number" min="1" name="follow_up_day" id="follow_up_day"  value="{{$qustion->follow_up_day}}" placeholder="enter follow up day">
						@else
					   <input class="form-control" type="number" min="1" name="follow_up_day" id="follow_up_day"  value="" placeholder="enter follow up day" disabled>

					    @endif
					   @endforeach

						</div>
                         </div>

                        <div class="form-group ">
                       <label class="control-label">Select Answer Type</label>
					   <div class="col-lg-6">
                        <select id="answer_type" class="form-control"  name="answer_type" required>
                        <!--<option value="1">Select An Answer Type</option>-->
                         <option value="single"<?php if($qustion->answerType =='single') echo "selected";?>>single</option>
                         <option value="multiple"<?php if($qustion->answerType =='multiple') echo "selected";?>>multiple</option>
                          <option value="rating"<?php if($qustion->answerType =='rating') echo "selected";?>>rating</option>
                         <option value="text"<?php if($qustion->answerType =='text') echo "selected";?>>text</option>                          
                        </select>
						</div>
                        </div>
                        <div class="form-group hide_data">
                      <label for="amount" class="control-label col-lg-3">Create Options</label>
                      <div class="col-lg-6">
                       <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus" aria-hidden="true"></i>
                       </a>
                  </div>
                    </div>
					@if($qustion->answerType =='single' OR $qustion->answerType =='multiple')
                         <div class="form-group ">
                      <label for="amount" class="control-label col-lg-3"></label>
					   <div class="col-lg-6 field_wrapper">
                      @foreach(json_decode($qustion->options) as $options)
                        <input class="form-control options" id="title" value="{{$options}}" name="options[]" type="text">
                      @endforeach  
                      </div>
                    </div>
					@endif
                    <br><br><br>
                    <div class="form-group ">
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

<script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="form-group "><div class="row"> <div class="col-lg-6"><input type="text" placeholder="add-options" class="form-control" id="options" name="options[]" value=""/></div><a href="javascript:void(0);" class="remove_button"><i class="fa fa-remove" aria-hidden="true"></i></a></div></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });
    
    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>

<script>
$(document).ready(function() {
  $("#answer_type").on('change',function(){
  var answer_type=$(this).val();
  if(answer_type=='rating' || answer_type=='text')
  {
    //alert(answer_type);
   $('.options').attr('disabled', 'disabled');
   $('.hide_data').hide();
      $('.hidden_op').attr('disabled', 'false');
  }
  else{
       $('.options').attr('disabled', false);
	      $('.hide_data').show();

  }

});


});

</script>
<script type="text/javascript">
$(document).ready(function(){  
  $("#question_type").change(function(){
    var rest1  = $(this).val();
    if(rest1 =="followUpQuestion")
    {
	  //$('#follow_up_day').attr('disabled', 'false');
	  $('#follow_up_day'). prop("disabled", false);
	 $('.follow-up').show();
    }
    else
    {
			  $('#follow_up_day'). prop("disabled", true);

	 // $('#follow_up_day').attr('disabled', 'true');
      $('.follow-up').hide();

    }
  });
});

</script>
  
  @endsection