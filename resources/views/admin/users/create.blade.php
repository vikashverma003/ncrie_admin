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
                  <h4 class="card-title">Create User</h4>
                  
                <form class="forms-sample" method="post" action="{{route('users.store')}}" enctype="multipart/form-data" id="create_company">
                  @csrf
                  <!--<div class="form-group required">
                    <div class="row">
                            <div class="col-md-6">
                      <label  class="control-label" for="user_type">Select User Type</label>
                     <select class="form-control" id="user_type" name="user_type" required>
                      <option value="">Select</option>
                     <option value="local" >Local</option>
                      <option value="remote" >Remote</option>
                     </select>
                   </div></div>
                    </div> -->
                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label class="control-label" for="name"> User Id </label>
                      <input type="text" name="user_id" class="form-control" id="user_id" value="{{$n}}" placeholder="user_id"
                       value="{{old('user_id')}}" disabled />
                       <input type="hidden" name="user_id" value="{{$n}}">
                     </div></div>
                    </div>
                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label  class="control-label" for="user_type">Training Options</label>
                     <select class="form-control" id="training_option" name="training_option" required>
                      <option value="">Select Training Options</option>
                     <option value="ABM_WITH_WORDS" >ABM_WITH_WORDS</option>
                     <option value="ABM_WITH_FACES" >ABM_WITH_FACES</option>
                     <option value="ACT_WITH_WORDS" >ACT_WITH_WORDS</option>
                    <option value="ACT_WITH_FACES" >ACT_WITH_FACES</option>
                      <option value="PLACEBO_WITH_WORDS" >PLACEBO_WITH_WORDS</option>
                     <option value="PLACEBO_WITH_FACES" >PLACEBO_WITH_FACES</option>
                     <option value="QUESTIONS" >QUESTIONS</option>

                     </select>
                    </div>
                  </div></div>

                    <div class="form-group study-data" style="display:none;" required>
                      
                      <label  class="control-label" for="study_id">Study Id</label>
                     <div class="fetch-data"></div>

                    </div>


                   <!-- <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label class="control-label" for="training_trial_count"> Pin
                      </label>
                      <input name="pin"
                      class="form-control"
                          oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                          type = "number"
                          maxlength = "4"
                          placeholder="pin"
						  min=1
                          required
                       />
                     </div></div>
                      
                    </div>-->
					<div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label class="control-label" for="training_trial_count"> Pin
                      </label>
                      <input name="password"
                      class="form-control"
                          oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                          type = "number"
                          maxlength = "4"
                          placeholder="password"
						  min=1
                          required
                       />
                     </div></div>
                      
                    </div>
                    
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    
                  </form>
                </div>
              </div>
            </div>
   </div>
</div>

@endsection

@section('footerScript')
@parent

<script>
$(document).ready(function() {

  $("#training_option").on('change',function(){
  var conditions=$(this).val();
  if(conditions!='')
  {
          $('.study-data').show();
  }
});
});
</script>


<script>
$(document).ready(function() {
  $("#training_option").on('change',function(){
  var conditions=$(this).val();
  var op=''; 
  //alert(conditions);
   $.ajax({
    type : 'POST',
    url : '{{route("match_studies")}}',
    data:{"_token": "{{ csrf_token() }}",'search':conditions},
    success:function(data2){
      //console.log(data2);
      var data3=data2.data;
      //console.log(data3);
       op+='<div class="col-md-6">';
            op+='<select class="form-control"  name="study_id" id="study_id">';
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

  
@endsection