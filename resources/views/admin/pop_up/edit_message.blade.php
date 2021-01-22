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
               
                  <h4 class="card-title">Edit Pop Up Message</h4>
                   @if (session('su_status'))
                  <div class="alert alert-success">{!! session('su_status') !!}</div>
                @endif
                <form class="forms-sample" method="post" action="{{url('/admin/update_message')}}/{{$pop_up_message->_id}}" enctype="multipart/form-data" id="create_company">
                  @csrf
				  
					  <div class="form-group ">
                       <label class="control-label">Select day</label>
					     <div class="col-md-6">
                        <select class="form-control"  name="day" id="day" required>
                        <!-- <option value="">Select Type</option> -->
						@for($i=0;$i<=57;$i++)  
                         <option value="{{$i}}">{{$i}}</option>
						 @endfor 
                        </select>
						</div>
                        </div>
						<div class="form-group ">
                       <label for="description" class="control-label col-lg-3">Message</label>
                      <div class="col-lg-6" >
                       <textarea name="message" class="form-control" col=10 row=10 placeholder="enter message" required>{{$pop_up_message->message}}</textarea>
                        
                      </div>
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

  
  @endsection