@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">
   <div class="row">
      <div class="col-lg-12 stretch-card">

         <div class="card">
            <div class="card-body">
            @if (\Session::has('success'))
                  <div class="alert alert-success">
                     {!! \Session::get('success') !!}
                  </div>
                @endif
                @if (\Session::has('error'))
                  <div class="alert alert-danger">
                     {!! \Session::get('error') !!}
                  </div>
                @endif
               <!-- <div>
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
                </div><br><br> -->
               <a class="nav-link add_button" href="{{route('words.create')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a>
               <div class="table-responsive">
                  <table class="table" id="study-table">
                     <thead>
                        <tr>
                           <th>Threat Word/Face</th>
                           <th>Neutral Word/Face</th>
                           <th>CreatedAt</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($words as $Words)
                        <tr>
                          <td>
                            @if($Words->threat_word !='')
                            {{$Words->threat_word}}
                              @else
                            <img src="{{asset('admin/images/faces')}}/{{$Words->threat_faces}}" width="100" height="100" alt="image"/>
                            @endif
                          </td>
                          <td>
                            
                            @if($Words->neutral_word !='')
                            {{$Words->neutral_word}}
                              @else
                            <img src="{{asset('admin/images/faces')}}/{{$Words->neutral_faces}}" width="100" height="100" alt="image"/>
                            @endif
                            </td>
                          <td>{{$Words->createdAt}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                      </table>
                      {{$words->links()}}

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
  
  @endsection
