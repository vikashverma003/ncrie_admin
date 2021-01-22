@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
   <div class="row">
      <div class="col-lg-12 stretch-card">

         <div class="card">
            <div class="card-body">
           @if (session('er_status'))
                  <div class="alert alert-danger">{!! session('er_status') !!}</div>
                @endif
                @if (session('su_status'))
                  <div class="alert alert-success">{!! session('su_status') !!}</div>
                @endif
               <h4 class="card-title"> Questions Listing</h4>
               <!--<a class="nav-link add_button" href="{{url('/admin/add_questions')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a> -->
                    <input type="text" placeholder="Search.." id="search" class="search" style="width:422px;">
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalExample">
               Create Question</button></div>

               <div class="table-responsive hide-table">
                  <table class="table" id="study-table">
                     <thead>
                        <tr>
                           <th>Question</th>
                           <th>Question Type</th>
                           <th>Answer Type</th>
                           <th>CreatedAt</th>
                           {{-- <th>Action</th> --}}
                        </tr>
                     </thead>
                     <tbody class="sort_menu">
                      @if(count($question)>0)
                        @foreach($question as $questions)
                        <tr class="row1" data-id="{{$questions['_id']}}">
                           <td ><span class="handle"></span>{{$questions['question']}}</td>
						   @if(is_array($questions['questionType']))
							   <td ><span class="handle"></span>
							   @foreach($questions['questionType'] as $ques=>$val)
							    {{$val}}
						       @endforeach
							   </td>
						    @else
						   <td ><span class="handle"></span>{{$questions['questionType']}}</td>
							@endif
						   
                           <td ><span class="handle" ></span>{{$questions['answerType']}}</td>
                           <td ><span class="handle" ></span>{{$questions['createdAt']}}</td> 
                          <td ><span class="handle"></span><a href="{{url('/admin/edit_question')}}/{{$questions['_id']}}"><i class="fa fa-pencil"></i></a>
                          <a onclick="return confirm('Are you sure you want to Delete?');" href="{{url('/admin/new_questions/')}}/{{$questions['_id']}}/delete" data-id="{{$questions['_id']}}" class="del_ques"><i class="fa fa-trash"></i></a></td> 
                          	<td><a href="{{url('/admin/add_duplicate_question')}}/{{$questions['_id']}}">Add Duplicate Row</a></td>					  
                        </tr>
                        @endforeach
                        @else
                        <tr><td>No questions found</td></tr>
                        @endif

                     </tbody>
                  </table>

               </div>
                                 {{$question->links()}}
                   <br><br>  

              <div id="tableview"></div> 

               <!-- Modal HTML Markup -->
<div id="ModalExample" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding:1px 26px;">
                <h4 class="modal-title text-xs-center">Create Questions</h4>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    @csrf
                    <input type="hidden" name="_token" value="">
                    <div class="form-group">
                        <label class="control-label">Question</label>
                        <div>
                        <textarea class="form-control"  name="question" id="question" rows="3" value="" placeholder="enter the question" required></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="study" id="study" value="{{$id}}">
                    <div class="form-group ">
                       <label class="control-label">Select Question Type</label>
                        <select class="form-control"  name="question_type[]" id="question_type" multiple required>
                       <!-- <option value="">Select An Question Type</option> -->
                        <option value="questionnaire">Pre Question </option>
                         <option value="assessment">Assessment Question</option>
                         <option value="training">Training Question</option>
						 <option value="last_day_questionnaire">Post Questionnaire</option> 
						 <option value="followUpQuestion"> Follow Up Question</option> 
                        </select>
                        </div>
						<div class="form-group follow-up">
                        <label class="control-label">Add Follow Up Day</label>
                        <div>
                        <input class="form-control" type="number" min="1" name="follow_up_day" id="follow_up_day"  value="" placeholder="enter follow up day"/ disabled>
                        </div>
                         </div>

                        <div class="form-group ">
                       <label class="control-label">Select Answer Type</label>
                        <select id="answer_type" class="form-control"  name="answer_type" id="answer_type" >
                        <!--<option value="1">Select An Answer Type</option>-->
                         <option value="single">single</option>
                         <option value="multiple">multiple</option>
                          <option value="rating">rating</option>
                         <option value="text">text</option>                          
                        </select>
                        </div>

                        <div class="form-group hide_data">
                      <label for="amount" class="control-label col-lg-3">Create Options</label>
                      <div class="col-lg-6">
                        <!--<input type="text" class="form-control" name="equipment_name[]"  value="" />-->
            
                       <a href="javascript:void(0);" class="add_button" title="Add field"><i class="fa fa-plus" aria-hidden="true"></i>
                       </a>
                    </div>
                    </div>

                      <div class="form-group ">
                      <label for="amount" class="control-label col-lg-3"></label>
                      <div class="col-lg-6 field_wrapper">
          
                      </div>
                     </div>

                      </div>
                      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" id="mySubmit" class="btn btn-secondary" disabled>Submit</button>

            
            </div>
                    
                    
                </form>
            </div>
          
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
            </div>
         </div>
      </div>
   </div>
</div>


@endsection
@section('headerScript')
@parent
@endsection

@section('footerScript')
@parent
<style>
    .list-group-item {
        display: flex;
        align-items: center;
    }

    .highlight {
        background: #f7e7d3;
        min-height: 30px;
        list-style-type: none;
    }

    .handle {
        min-width: 18px;
        background: #607D8B;
        height: 15px;
        display: inline-block;
        cursor: move;
        margin-right: 10px;
    }
</style>

<script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

<script>
$(document).ready(function(){
// $(".check_id").click(function(){
//   alert(232);
// });
//  $( ".sort_menu" ).sortable({
//           items: "tr",
//           cursor: 'move',
//           opacity: 0.6,
//           update: function() {
//               sendOrderToServer();
//           }
//         });

// function sendOrderToServer() {
//           var order = [];
//           var token = $('meta[name="csrf-token"]').attr('content');
//           $('tr.row1').each(function(index,element) {
//             order.push({
//               id: $(this).attr('data-id'),
//               position: index+1
//             });
//             alert(id);
//           });

// }
 })



</script>

<script>
$(document).ready(function(){

    function updateToDatabase(idString){
      // var dataId = $(elem).data("id");
      //alert(idString);
       // var d=$(this).data("id");
       // alert(d);
    //alert(dataId);
         $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});
         $.ajax({
              url:'{{url('/admin/update_order')}}',
              method:'POST',
              data:{ids:idString},
              success:function(data){
                 //console.log(data);
                 //alert('Successfully updated')
                 //do whatever after success
              }
           })
      }
    var target = $('.sort_menu');
        target.sortable({            
            handle: '.handle',
            placeholder: 'highlight',
            axis: "y",
            update: function (e, ui){
               var sortData = target.sortable('toArray',{ attribute: 'data-id'})
               updateToDatabase(sortData.join(','))
            }
        })
        })
</script>

<script type="text/javascript">
$('#search').on('keyup',function(){
$value=$(this).val();
var id='{{$id}}';
  var op ="";

if($value!='')
    {
            $('.hide-table').hide();
                  $('#tableview').show();

    }
    else
    {
      $('.hide-table').show();
      $('#tableview').hide();
    }

//alert($value);
$.ajax({
type : 'POST',
url : '{{route("search")}}',
data:{"_token": "{{ csrf_token() }}",'search':$value,'id':id},
success:function(data2){
  //console.log(data2.data.length);
  var data3=data2.data;
  console.log(data3);
   op+='<table class="table table-striped">';
        op+='<tr><th>Question</th><th>Question Type</th><th>Answer Type </th><th> CreatedAt</th></tr>';
        for(var i=0;i<data3.length;i++){
          op+='<tr>';
          op+='<td>'+data3[i].question+'</td><td>'+data3[i].questionType+'</td><td>'+data3[i].answerType+'</td><td>'+data3[i].createdAt+'</td></tr>';
        }
         op+='</table>';
         $('#tableview').html(op);
//$('tbody').html(data);
}
});
})
</script>
<script type="text/javascript">
$.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
</script>

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
  $("#answer_type").change(function(){
    var rest  = $(this).val();
	
	

    if(rest =="rating"||rest =="text")
    {
	  //alert(rest);
	 $('#mySubmit'). prop("disabled", false);
      $('.hide_data').hide();
    }
    else
    {
		$('#mySubmit'). prop("disabled", true);
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


<script type="text/javascript">
$(document).on('submit','#editProfileForm',function(e){
  //alert(232);
            e.preventDefault();

            var question=$("#question").val();
            var study=$("#study").val();
            var question_type=$("#question_type").val();
            var answer_type=$("#answer_type").val();
           var follow_up_day=$("#follow_up_day").val();
           var ris = new Array();
            $("input[name^='options']").each(function() {
                ris.push($(this).val());
			});
		//	alert(ris);
			//alert(follow_up_day);
		 var newClass = (ris !='') ? ris : '';
         if(answer_type=='single'||answer_type=='multiple'){
			 
			 if(newClass!=''){
				 $.ajax({
                type:'POST',
                
                url:'{{route("add_questionss")}}',
                data:{
                      "_token": "{{ csrf_token() }}",
                      'status': 1,
                      'question':question,
                      'question_type':question_type,
                      'answer_type':answer_type,
                      'study':study,
                      'options':newClass,
					  'follow_up_day':follow_up_day,
                    },

                success:function(response){
                  console.log(response);
                  if(response.status==1)
                  {
                  console.log(232);
                  location.reload();
                  }
                  else
                  {
                    console.log(333);
                  }
                                         
                },
                error:function(data){
                   
                   console.log(data);
                   console.log(00);
                }
            });
				 
			 }
			 else{
				 alert("Please select input field");
			 }
			 
		 }else{
			 $.ajax({
                type:'POST',
                
                url:'{{route("add_questionss")}}',
                data:{
                      "_token": "{{ csrf_token() }}",
                      'status': 1,
                      'question':question,
                      'question_type':question_type,
                      'answer_type':answer_type,
                      'study':study,
                      'options':newClass,
					  'follow_up_day':follow_up_day,
                    },

                success:function(response){
                  console.log(response);
                  if(response.status==1)
                  {
                  console.log(232);
                  location.reload();
                  }
                  else
                  {
                    console.log(333);
                  }
                                         
                },
                error:function(data){
                   
                   console.log(data);
                   console.log(00);
                }
            });
			 
		 }		 
            
        });


</script>


<!--<script>
 $(document).ready(function(){
  $(document).on('click','.del_ques',function(e){
	 var d= $(this).data('id');
	 e.preventDefault();
        swal({
           title: "Sure",
           text: "Do you want to Delete?",
           icon: "warning",
           buttons: true,
           dangerMode: false,
       })
	   //.then((willconfirm) => {
           //if (willconfirm) {
                $.ajax({
                    type:'post',
                    url:"{{url('/admin/new_questions')}}"+"/"+d+"/"+"delete",
                    data:{
                      "_token": "{{ csrf_token() }}",
                     // 'code':code,
                      'status': 1
                    },
                    success:function(response){
						console.log(response);
						if(response.status==1){
						location.reload();
						}
                       /* if(response.status==1){
                            swal({title: "Status Changed", text: response.message, type: "success"}).then(function(){ 
                                location.reload();
                            });
                        }else{
                          swal("Oops!", response.message, "error");
                        }*/
                    },
                    error:function(err){
						console.log(err);
                        //stopLoader('body');
                    }
                });
           //}
        //});
       
	
	
	
	
  });
	});






</script>-->


  
  @endsection
