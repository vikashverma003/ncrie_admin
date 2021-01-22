@extends('admin.layouts.app')
@section('title',$title)
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
               <h4 class="card-title">{{$title}}</h4>
               <a class="nav-link add_button" href="{{route('study.create')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a>
              <table class="table table-striped">
                <thead>
                  <tr>
                   <th>Study Id</th>
                    <th>Training Cycle</th>
                    <th>Extension Days</th>
                    <th>CreatedAt</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($study as $studies)
                  <tr>
                    <td><a href="{{url('/admin/all_questions')}}/{{$studies->_id}}">{{$studies->studyId}}</a></td>
                    <td>{{$studies->trainingCycle}}</td>
                    <td>{{$studies->maximumDays}}</td>
                    <td>{{$studies->createdAt}}</td>
                  </tr>
                  @endforeach
                </tbody>

              </table>
    
            </div>
                                                    {{$study->links()}}

         </div>
      </div>
   </div>
</div>
@endsection
@section('headerScript')
@parent
<link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('footerScript')
@parent
<script src="//code.jquery.com/jquery.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


  @endsection
