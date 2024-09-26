@section('header')
    @include('admin.dashboard.header')
@show


    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        @section('sidebar')
            @include('admin.dashboard.sidebar')
        @show
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        @yield('content')


    </div><!-- /.content-wrapper -->
   @section('footer')
       @include('admin.dashboard.footer')
    @show

