@extends('admin.layouts.app')
@section('title',$title)
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
                  <h4 class="card-title">{{$title}}</h4>
                  
                <form class="forms-sample" method="post" action="{{route('study.store')}}" enctype="multipart/form-data" id="create_company">
                  @csrf
                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label class="control-label" for="name"> Study </label>
                      <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                       value="{{old('name')}}" required />
                    @if ($errors->has('name'))
                    <div class="error">{{ $errors->first('name') }}</div>
                    @endif
                  </div>
                  </div>
                    </div>
                    <div class="form-group required">
                          <div class="row">
                            <div class="col-md-6">
                      <label  class="control-label" for="training_cycle">Select Training Cycle</label>
                     <select class="form-control" id="training_cycle" name="training_cycle" required>
                      <option value="">Select Training Cycle</option>
                       @for($i=1;$i<=6;$i++)
                     <option value={{$i}} >{{$i}}</option>
                       @endfor
                     </select>
                    @if ($errors->has('training_cycle'))
                    <div class="error">{{ $errors->first('training_cycle') }}</div>
                    @endif
                     </div>
                            <div class="col-sm-2">
                      <label  class="control-label" for="training_cycle"></label>
                      <div class="input-group">
                            <a href="" data-toggle="modal" data-target="#ModalExample">?<a>                             
                       </div>
                      </div>
                        </div>
                    </div>

                    <!--<div class="form-group required">
                      <label  class="control-label" for="total_days">Select Total Days 
                      </label>
                     <select class="form-control" id="total_days" name="total_days" required>
                      <option value="">Total Days</option>
                       @for($i=1;$i<=57;$i++)
                     <option value={{$i}} >{{$i}}</option>
                       @endfor
                     </select>
                    @if ($errors->has('total_days'))
                    <div class="error">{{ $errors->first('total_days') }}</div>
                    @endif
                    </div> -->

                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label  class="control-label" for="maximum_days">Select Maximum Days (For extending)
                      </label>
                     <select class="form-control" id="maximum_days" name="maximum_days" required>
                      <option value="">Maximum Days</option>
                       @for($i=0;$i<=30;$i++)
                     <option value={{$i}} >{{$i}}</option>
                       @endfor
                     </select>
                    @if ($errors->has('maximum_days'))
                    <div class="error">{{ $errors->first('maximum_days') }}</div>
                    @endif
                  </div></div>
                    </div>
                   

                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label class="control-label" for="assessment_duration"> Assessment Duration (in milliseconds)
                      </label>
                      <input type="number" name="assessment_duration" class="form-control" id="assessment_duration" placeholder="Duration"
                       value="{{old('assessment_duration')}}" min="100" max="2000" required />
                    @if ($errors->has('assessment_duration'))
                    <div class="error">{{ $errors->first('assessment_duration') }}</div>
                    @endif
                  </div></div>
                    </div>

                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label class="control-label" for="assessment_trial_count"> Assessment Trial Count
                      </label>
                      <input type="number" name="assessment_trial_count" class="form-control" id="trial_count" min="1" max="1000" placeholder="Trial Count"
                       value="{{old('assessment_trial_count')}}" required />
                    @if ($errors->has('assessment_trial_count'))
                    <div class="error">{{ $errors->first('assessment_trial_count') }}</div>
                    @endif
                  </div></div>
                    </div>



                    
                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label class="control-label" for="training_duration"> Training Duration (in milliseconds)
                      </label>
                      <input type="number" name="training_duration" class="form-control" id="training_duration" min="100" max="2000" placeholder="Duration"
                       value="{{old('training_duration')}}" required />
                    @if ($errors->has('training_duration'))
                    <div class="error">{{ $errors->first('training_duration') }}</div>
                    @endif
                  </div></div>
                    </div>

                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label class="control-label" for="training_trial_count"> Training Trial Count
                      </label>
                      <input type="number" name="training_trial_count" class="form-control" id="training_trial_count" min="1" max="1000" placeholder="Training Count"
                       value="{{old('training_trial_count')}}" required />
                    @if ($errors->has('training_trial_count'))
                    <div class="error">{{ $errors->first('training_trial_count') }}</div>
                    @endif
                  </div></div>
                    </div>
                   
                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      <label  class="control-label" for="maximum_days"> Condition 
                      </label>
                     <select class="form-control" id="condition" name="condition[]" multiple required>
                      <!-- <option value="">Select Condtion</option> -->
                       @foreach($condition as $value)
                     <option value="{{$value}}" >{{$value}}</option>
                       @endforeach
                     </select>
                    @if ($errors->has('condition'))
                    <div class="error">{{ $errors->first('condition') }}</div>
                    @endif
                  </div></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    
                  </form>
                </div>
              </div>
            </div>
   </div>
</div>


               <!-- Modal HTML Markup -->
<div id="ModalExample" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-xs-center">Training Cycle</h4>
            </div>
            <div class="modal-body">
                <div id="tableview"></div> 
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">OK</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('footerScript')
@parent

<script type="text/javascript">
$(document).ready(function(){
  
  $("#training_cycle").change(function(){    
    var cycle = $(this).val(); 
      var op ="";

    //alert(cycle);
    $.ajax({
    type : 'POST',
    url : '{{route("training_cycle")}}',
    data:{"_token": "{{ csrf_token() }}",'search':cycle},
    success:function(data2){

      console.log(data2);
      //console.log(data2.data.length);
      var data3=data2.data;
      console.log(data3);
       op+='<table class="table table-striped">';
            op+='<tr><th>Day</th><th>Question</th><th>Dot Probe</th></tr>';
            for(var i=0;i<data3.length;i++){
              op+='<tr>';
              op+='<td>'+data3[i]+'</td><td>'+'<input type="checkbox" name="question" checked/>'
+'</td><td>'+'<input type="checkbox" name="question" checked/>'+'</td></tr>';
            }
             op+='</table>';
             $('#tableview').html(op);
    }
    });
    
  });
  
  
});

</script>
  
  @endsection