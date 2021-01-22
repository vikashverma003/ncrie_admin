 
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('admin/node_modules/mdi/css/materialdesignicons.min.css')}}" />
  <link rel="stylesheet" href="{{asset('admin/node_modules/simple-line-icons/css/simple-line-icons.css')}}" />
  <link rel="stylesheet" href="{{asset('admin/node_modules/flag-icon-css/css/flag-icon.min.css')}}" />
  <link rel="stylesheet" href="{{asset('admin/node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css')}}" />
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('admin/css/style.css')}}" />
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('admin/images/favicon.png')}}" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/x-icon" href="{{asset('/web/images/favicon.ico')}}">

<style>
  .content-wrapper {
background: #efefef;
  }
  .navbar {
    font-family: "roboto-medium", sans-serif;
    background: linear-gradient(88deg, #0c4b9d,#0c4b9d);
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-settings{
    border: 1px solid rgb(255,255, 255);

  }
  a.nav-link,button.navbar-toggler.navbar-toggler.align-self-center,span.btn,a.nav-link{
    color:black !important;
  }
  span.btn{
    background:rgba(255, 255, 255, 0.72) !important;
  }
  .footer a {
    color: #0c4b9d;
    font-size: inherit;
}
input.btn.btn-block.btn-success.btn-lg.font-weight-medium{
  color: rgba(0, 0, 0, 0.87);
    font-size: 18px;
    font-weight: 500;
    font-family: 'Graphik';
    letter-spacing: 1.13px;
    border-radius: 4px;
    background-color: #0c4b9d;
    border: none;
    padding: 10px 45px;
    outline: none;
}
.btn:hover {
    transform: scale(0.97);
}
.btn {
    transition: .2s ease-in;
}
.text-success{
  color:#0c4b9d !important;
}
li.nav-item.active, li.nav-item:hover {
    background: #0c4b9d;
    color:white !important;
}
li.nav-item.active a.nav-link,button.navbar-toggler.navbar-toggler.align-self-center,li.nav-item.nav-settings.d-none.d-lg-block a.nav-link{
  color:white !important;
}
.sidebar .nav:not(.sub-menu) > .nav-item:hover:not(.nav-profile) > .nav-link {
    background: #0c4b9d !important;
    color:white !important;
}
table#datatable_ajax td{
    min-width:220px !important;
}
  </style>
@section('headerScript')
@show