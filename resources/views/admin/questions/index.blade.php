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
               <h4 class="card-title">Security Questions</h4>
               <a class="nav-link add_button" href="{{route('questions.create')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a>
               <div class="table-responsive">
                  <table class="table" id="study-table">
                     <thead>
                        <tr>
                           <th>Question</th>
                           <th>CreatedAt</th>
                           {{-- <th>Action</th> --}}
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($questions as $question)
                        <tr>
                           <td>{{$question->question}}</td>
                           <td>{{$question->createdAt}}</td>
                           <td><a href="{{url('/admin/questions')}}/{{$question->id}}/edit"><i class="fa fa-pencil"></i>
</a><a onclick="return confirm('Are you sure you want to Delete?');" href="{{url('/admin/questions')}}/{{$question->id}}/delete"><i class="fa fa-trash"></i></a></td>
                        <tr>
                        @endforeach
                     </tbody>
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
@endsection

@section('footerScript')
@parent

  
  
  @endsection
