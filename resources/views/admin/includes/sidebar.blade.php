
<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <div class="nav-link">
                <div class="profile-image">
                  <img src="{{asset('admin/images/dummy-image.jpg')}}" alt="image" />
                  <span class="online-status online"></span> <!--change class online to offline or busy as needed-->
                </div>
                <div class="profile-name">
                  <p class="name">
                  {{auth()->user()->name}}
                  </p>
                  <p class="designation">
                 Admin
                  </p>
                </div>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/dashboard')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">Dashboard</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/users')}}">
                <i class="icon-people menu-icon"></i>
                <span class="menu-title">Users</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/questions')}}">
			  <i class="fa fa-question-circle-o menu-icon" aria-hidden="true"></i>
                <span class="menu-title">Security Questions</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/study')}}">
                <i class="icon-notebook menu-icon"></i>
                <span class="menu-title">Study</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>

            
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/words')}}">
                <i class="fa fa-file-word-o menu-icon"></i>                
                <span class="menu-title">Words</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>
			
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/show_messages')}}">
                <!--<i class="fa fa-file-word-o"></i>-->
                <i class="fa fa-envelope-open menu-icon" aria-hidden="true"></i>                
                <span class="menu-title">Add Pop Message</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>	
			
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/all_feedback_question')}}">
                <!--<i class="fa fa-file-word-o"></i>-->
                <i class="fa fa-question-circle menu-icon" aria-hidden="true"></i>
               
                <span class="menu-title">Add Feedback Question</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>
           
          </ul>
        </nav>
        <!-- partial -->