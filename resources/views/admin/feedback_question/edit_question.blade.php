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
                  <h4 class="card-title">Edit Training Questions</h4>
                  
                <form class="forms-sample" method="post" action="{{url('admin/update_question')}}" enctype="multipart/form-data" id="create_company">
                  @csrf
				  <!--<div class="form-group ">
                       <label class="control-label">Select Question Type</label>
					   <div class="col-lg-6">
                        <select class="form-control"  name="training_type" id="training_type" required>
                        <option value="training">Training</option>
                        </select>
						</div>
                        </div>
                
                      <div class="form-group">
                        <label class="control-label">Question</label>
						<div class="col-lg-6">           
						<textarea class="form-control"  name="question" id="question" rows="3" placeholder="please enter the question" required></textarea>
				       </div>
                    </div>-->
                    <input type="hidden" name="pre_id" value="{{$feedback->_id}}">
                    <div class="form-group">
                        <label class="control-label">Question</label>
                        <div class="col-lg-6">
                        <textarea class="form-control" name="question" id="question" rows="3" value="" placeholder="enter the question" required>{{$feedback->question}}</textarea>
                        </div>
                    </div>
                    <div class="form-group ">
                       <label class="control-label">Select Question Type</label>
					   <div class="col-lg-6">
                        <select class="form-control"  name="question_type" id="question_type"  required>
                         <option @if($feedback->questionType == 'training') selected="selected" @endif value="training">Training Question</option>
                        </select>
                        </div>
						</div>
						

                        <div class="form-group ">
                       <label class="control-label">Select Answer Type</label>
					   	<div class="col-lg-6">
                        <select id="answer_type" class="form-control"  name="answer_type" required>
                         <option @if($feedback->answerType == 'single') selected="selected" @endif  value="single">single</option>
                         <option @if($feedback->answerType == 'multiple') selected="selected" @endif  value="multiple">multiple</option>
                          <option @if($feedback->answerType == 'rating') selected="selected" @endif  value="rating">rating</option>
                         <option @if($feedback->answerType == 'text') selected="selected" @endif  value="text">text</option>                          
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

                      <div class="form-group ">
                      <label for="amount" class="control-label col-lg-3"></label>
                      <div class="col-lg-6 field_wrapper">
                        @if(!empty($feedback->options))
                          @foreach(json_decode($feedback->options) as $option)

                          <div class="form-group ">
                            <div class="row"> 
                              <div class="col-lg-6">
                                <input type="text" placeholder="add-options" class="form-control input_field" id="options" name="options[]" value="{{$option}}"/>
                              </div>
                              <a href="javascript:void(0);" class="remove_button"><i class="fa fa-remove" aria-hidden="true"></i></a>
                            </div>
                          </div>

                          @endforeach
                        @endif

                      </div>
                     </div>	
                    <div class="form-group ">
                      <button type="submit" id="mySubmit"  class="btn btn-primary mr-2">Update</button>
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

<script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div class="form-group "><div class="row"> <div class="col-lg-6"><input type="text" placeholder="add-options" class="form-control input_field" id="options" name="options[]" value=""/></div><a href="javascript:void(0);" class="remove_button"><i class="fa fa-remove" aria-hidden="true"></i></a></div></div>'; //New input field html 
    var x = 1; //Initial field counter is 1
    
    //Once add button is clicked
    $(addButton).click(function(){
        //Check maximum number of input fields
        if(x < maxField){ 
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
		    $('#mySubmit'). prop("disabled", false);

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


<script type="text/javascript">

$(document).ready(function(){  



    var rest  = $("#answer_type").val();
    if(rest =="rating"||rest =="text")
    {
      $('.hide_data').hide();
      $('.field_wrapper').hide();
    }
    else
    {
       $('.hide_data').show();
       $('.field_wrapper').show();
    }


  $("#answer_type").change(function(){
    var rest  = $(this).val();
    if(rest =="rating"||rest =="text")
    {
	 $('#mySubmit'). prop("disabled", false);
      $('.hide_data').hide();
      $('.field_wrapper').hide();
    }
    else
    {
		$('#mySubmit'). prop("disabled", true);
       $('.hide_data').show();
       $('.field_wrapper').show();
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


  $('#mySubmit').click(function(){
      
      var answerType = $('#answer_type').val();

      if(answerType == 'single' || answerType == 'multiple'){

        var numItems = $('.input_field').length;

        if(numItems == 0){
          alert('Please Add Options Field');
          return false;
        }else{

              var checkInput = 'yes';
              $(".input_field").each(function() { 
                    if($(this).val() == ''){
                      checkInput = 'no';
                    }
               });

              if(checkInput == 'no'){
                  alert('All options fields are required.');
                  return false;
              }
        }
      }

  })



});

</script>

  
  @endsection