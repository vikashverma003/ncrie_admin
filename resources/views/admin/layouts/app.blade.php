<!DOCTYPE html>
<html lang="en">

<head>
<!-- Required meta tags -->
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <title>@yield('title','MindHelp')</title>
  @include('admin.includes.head')
 </head>

<body>
<div class="container-scroller">
@include('admin.includes.header')

    <div class="container-fluid page-body-wrapper">
      <div class="row row-offcanvas row-offcanvas-right">
      @include('admin.includes.sidebar')
        <!-- partial:partials/_settings-panel.html -->
        @yield('content')
        <!-- content-wrapper ends -->
        @include('admin.includes.footer')
      </div>
      <!-- row-offcanvas ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  @include('admin.includes.footer-script')
</body>

</html>