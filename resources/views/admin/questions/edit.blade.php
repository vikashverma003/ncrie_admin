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
                  <h4 class="card-title">Edit Security Questions</h4>
                  
                <form class="forms-sample" method="post" action="{{url('admin/questions')}}/{{$questions->_id}}/update" enctype="multipart/form-data" id="create_company">
                  @csrf
                 
                    <div class="form-group required">
                      <label class="control-label" for="name"> Question </label>
                      <input type="text" name="question" class="form-control" id="question" placeholder="question"
                       value="{{$questions->question}}" required />
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