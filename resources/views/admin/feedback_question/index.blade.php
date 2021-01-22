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
               <h4 class="card-title"> Question Listing</h4>
			   <a class="nav-link add_button" href="{{url('/admin/add_question')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a> 
              </div>
               <div class="table-responsive hide-table">
                  <table class="table" id="study-table">
                     <thead>
                        <tr>
                           <th>Question</th>
                           <th>Created At</th>
						                <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                      @if(count($all_question)>0)
                        @foreach($all_question as $all_questions)					
                        <tr>
                            <td >{{$all_questions['question']}}</td>
                           <td >{{$all_questions['createdAt']}}</td> 
                           <td > 
                            <a href="{{url('/admin/feedback/delete/'.$all_questions['_id'])}}" onclick='return flight_deleteItem()'> Delete </a>&nbsp;&nbsp;
                            <a href="{{url('/admin/feedback/edit/'.$all_questions['_id'])}}"> Edit </a></td> 
                        </tr>
                        @endforeach
                        @else
                        <tr><td>No questions found</td></tr>
                        @endif

                     </tbody>
                  </table>
               </div>
<!-- /.modal-dialog -->
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


<script type="text/javascript">
  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  // if (result.isConfirmed) {
  //   Swal.fire(
  //     'Deleted!',
  //     'Your file has been deleted.',
  //     'success'
  //   )
  // }
})


function flight_deleteItem() {
    if (confirm("Are you sure you want to delete?")) {
        // your deletion code
        return true;
    }else{

        return false;   
    }
}

</script>
  
  @endsection
