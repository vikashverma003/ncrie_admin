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
                <div>
                   <form class="forms-sample" method="post" action="{{route('upload_words')}}" enctype="multipart/form-data" id="create_company">
                  @csrf
                    
                    <div class="form-group required">
                      <div class="row">
                            <div class="col-md-6">
                      </label>
                      <input type="file" name="csv_file" id="csv_file" placeholder="csv_file"
                        required />
                    @if ($errors->has('csv_file'))
                    <div class="error">{{ $errors->first('csv_file') }}</div>
                    @endif
                    </div>
                  </div></div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button> 
                  </form>
                </div><br><br>
               <a class="nav-link add_button" href="{{route('words.create')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a>
               <div class="table-responsive">
                  <table class="table" id="study-table">
                     <thead>
                        <tr>
                           <th>Threat Word/Faces</th>
                           <th>Neutral Word/Faces</th>
                           <th>Delete</th>
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
        ajax: '{!! route('wordData') !!}',
        columns: [
           {
            data: null,
            name: 'threat_word',"render": function (data, type, row) {
 
            if (row.threat_word== null) {
                return '<img src='+data.threat_faces_original+'>';}
                else{
                  return row.threat_word
                }
            }  
        },
        {
            data: null,
            name: 'neutral_word',"render": function (data, type, row) {
 
            if (row.neutral_word== null) {
                return '<img src='+data.neutral_faces_original+'>';}
                else{
                  return row.neutral_word
                }
            }  
        },
		   /* {
            data: '_id',
            name: '_id', "render": function (data, type, row) {
 // console.log(row.createdAt);
 console.log(row);
 // console.log(type);
 // console.log(row);
                return "<a href='{{url('/admin/edit_words')}}/"+row.data_id+"'>" + 'Edit' + "</a>";
            }
            
        },*/
		{
            data: '_id',
            name: '_id', "render": function (data, type, row) {
           console.log(row);
                return "<a href='{{url('/admin/delete_words')}}/"+row.data_id+"'>" + '<i class="fa fa-trash"></i>' + "</a>";
            }
            
        },
            { data: 'createdAt', name: 'createdAt'},
        ],
		order: [3, 'desc'],
    });
});
</script>
  
  @endsection
