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
               <div class="table-responsive">
                  <table class="table" id="study-table">
                     <thead>
                        <tr>
                           <th>Study Id</th>
                           <th>Training Cycle</th>
                           <th>Total Days</th>
                           <th>CreatedAt</th>
                           {{-- <th>Action</th> --}}
                        </tr>
                     </thead>
                                    </table>
               </div>
            </div>
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
<script>
$(function() {
    $('#study-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('studyData') !!}',
        columns: [
            { data: 'studyId', name: 'studyId' },
            { data: 'trainingCycle', name: 'trainingCycle' },
            { data: 'maximumDays', name: 'maximumDays' },
            { data: 'createdAt', name: 'createdAt' },
        ]
    });
});
</script>
  
  
  @endsection
