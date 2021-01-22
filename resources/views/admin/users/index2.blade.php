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
               <div class="table-responsive">
                  <table class="table" id="study-table">
                     <thead>
                        <tr>
                           <th>Check</th>
                           <th>UserID</th>
                           <th>StudyId</th>
                           <th>Option</th>
                           <th>Report</th>
                           <th>Info</th>
                           <th>Change Pin</th>
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
        ajax: '{!! route('usersData') !!}',
        columns: [
		            { data: 'userId', name: 'userId' },
                  { data: 'options', name: 'options' },
                  { data: 'createdAt', name: 'createdAt' },
]
        
    });
});
</script>
  
  @endsection
