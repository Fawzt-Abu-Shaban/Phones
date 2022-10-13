<?php
use App\Models\Order;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Auth;

// $order = Order::first();

?>

<!DOCTYPE html>

<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mobile | @yield('titel')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('cms/plugins/select2/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">


    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    @yield('style')

</head>

<body class="hold-transition sidebar-mini dark-mode">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand dark-mode
         {{-- navbar-white navbar-light --}}
         ">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('dashboard') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form action="{{ route('searching') }}" method="GET" class="form-inline">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" name="search"
                                    id="search" placeholder="Search..." aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>


                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        {{-- <span class="badge badge-warning navbar-badge">1</span> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>

                        {{-- @if (auth()->user()->admin)
                            @forelse ($notifications as $notification) --}}
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item ">
                            <a href="#" class="mark-as-read" {{-- data-id="{{ $notification->id }}" --}} {{-- <i class="fas fa-envelope mr-2"></i> --}}>
                                <i class="fas fa-solid fa-check mr-2"></i></a>
                            New Order From Foozi
                            <span class="float-right text-muted text-sm">4-5-2022</span>
                        </a>

                        {{-- @empty
                                There Are No New Notification
                            @endforelse
                        @endif --}}

                        <div class="dropdown-divider"></div>

                        <a href="#" id="mark-all" class="dropdown-item "> Mark All As Read</a>

                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> --}}

            </ul>
        </nav>
        <!-- /.navbar -->

        {{-- <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside> --}}

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('cms/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('cms/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                {{-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">

                        <input class="form-control form-control-sidebar searchable-field" type="search"
                            placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar searchable-field">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="form-group"> --}}
                <select name="search" id="searchable-field" class="form-control searchable-field">
                </select>
                {{-- </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        {{-- menu-open --}}
                        {{-- active --}}
                        <li class="nav-item ">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    DashBoard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('dashboard') }}" class="nav-link active">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Active Page</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Inactive Page</p>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>

                        @canany(['Create-Admin', 'Read-Admins', 'Create-User', 'Read-Users'])
                            <li class="nav-header">HUMAN RESOURCES</li>
                            @canany(['Create-Admin', 'Read-Admins'])
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-solid fa-user-secret"></i>
                                        <p>
                                            Admins
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('Read-Admins')
                                            <li class="nav-item">
                                                <a href="{{ route('admins.index') }}" class="nav-link">
                                                    <i class="fas fa-list-ul nav-icon"></i>
                                                    <p>index</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('Create-Admin')
                                            <li class="nav-item">
                                                <a href="{{ route('admins.create') }}" class="nav-link">
                                                    <i class="fas fa-plus-circle nav-icon"></i>
                                                    <p>create</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                            @canany(['Create-User', 'Read-Users'])
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>
                                            Users
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('Read-Users')
                                            <li class="nav-item">
                                                <a href="{{ route('users.index') }}" class="nav-link">
                                                    <i class="fas fa-list-ul nav-icon"></i>
                                                    <p>index</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('Create-User')
                                            <li class="nav-item">
                                                <a href="{{ route('users.create') }}" class="nav-link">
                                                    <i class="fas fa-plus-circle nav-icon"></i>
                                                    <p>create</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany
                        @endcanany

                        @canany(['Create-Role', 'Read-Roles', 'Create-Permission', 'Read-Permissions'])
                            <li class="nav-header">ROLES & PERMISSIONS</li>
                            @canany(['Create-Role', 'Read-Roles'])
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fab fa-critical-role"></i>
                                        <p>
                                            Roles
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('Read-Roles')
                                            <li class="nav-item">
                                                <a href="{{ route('role.index') }}" class="nav-link">
                                                    <i class="fas fa-list-ul nav-icon"></i>
                                                    <p>index</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('Create-Role')
                                            <li class="nav-item">
                                                <a href="{{ route('role.create') }}" class="nav-link">
                                                    <i class="fas fa-plus-circle nav-icon"></i>
                                                    <p>create</p>
                                                </a>
                                            </li>
                                        @endcan


                                    </ul>
                                </li>
                            @endcanany
                            @canany(['Create-Permission', 'Read-Permissions'])
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon far fa-id-badge"></i>
                                        <p>
                                            Permissions
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @can('Read-Permissions')
                                            <li class="nav-item">
                                                <a href="{{ route('permission.index') }}" class="nav-link">
                                                    <i class="fas fa-list-ul nav-icon"></i>
                                                    <p>index</p>
                                                </a>
                                            </li>
                                        @endcan
                                        @can('Create-Permission')
                                            <li class="nav-item">
                                                <a href="{{ route('permission.create') }}" class="nav-link">
                                                    <i class="fas fa-plus-circle nav-icon"></i>
                                                    <p>create</p>
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </li>
                            @endcanany

                        @endcanany

                        {{-- @canany(['Create-Category', 'Create-Type', 'Create-Product', 'Create-Slider']) --}}
                        <li class="nav-header">CONTENT MANAGMENT</li>
                        {{-- @canany(['Create-Category']) --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    Categories
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('category.index') }}" class="nav-link">
                                        <i class="fas fa-list-ul nav-icon"></i>
                                        <p>index</p>
                                    </a>
                                </li>
                                @can('Create-Category')
                                    <li class="nav-item">
                                        <a href="{{ route('category.create') }}" class="nav-link">
                                            <i class="fas fa-plus-circle nav-icon"></i>
                                            <p>create</p>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </li>
                        {{-- @endcanany --}}
                        {{-- @canany(['Create-Type']) --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-solid fa-spa"></i>
                                <p>
                                    Types
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('type.index') }}" class="nav-link">
                                        <i class="fas fa-list-ul nav-icon"></i>
                                        <p>index</p>
                                    </a>
                                </li>
                                @can('Create-Type')
                                    <li class="nav-item">
                                        <a href="{{ route('type.create') }}" class="nav-link">
                                            <i class="fas fa-plus-circle nav-icon"></i>
                                            <p>create</p>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </li>
                        {{-- @endcanany --}}
                        {{-- @canany(['Create-Product']) --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>
                                    Products
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('product.index') }}" class="nav-link">
                                        <i class="fas fa-list-ul nav-icon"></i>
                                        <p>index</p>
                                    </a>
                                </li>
                                @can('Create-Product')
                                    <li class="nav-item">
                                        <a href="{{ route('product.create') }}" class="nav-link">
                                            <i class="fas fa-plus-circle nav-icon"></i>
                                            <p>create</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        {{-- @endcanany --}}
                        {{-- @canany(['Create-Slider']) --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-sliders-h"></i>
                                <p>
                                    Slider
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('slider.index') }}" class="nav-link">
                                        <i class="fas fa-list-ul nav-icon"></i>
                                        <p>index</p>
                                    </a>
                                </li>
                                @can('Create-Slider')
                                    <li class="nav-item">
                                        <a href="{{ route('slider.create') }}" class="nav-link">
                                            <i class="fas fa-plus-circle nav-icon"></i>
                                            <p>create</p>
                                        </a>
                                    </li>
                                @endcan


                            </ul>
                        </li>
                        @can('Read-Orders')
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    {{-- <i class="nav-icon fas fa-sliders-h"></i> --}}
                                    <i class="nav-icon fab fa-jedi-order"></i>
                                    <p>
                                        Order
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('orders.index') }}" class="nav-link">
                                            <i class="fas fa-list-ul nav-icon"></i>
                                            <p>index</p>
                                        </a>
                                    </li>
                                    {{-- @can('Create-Slider') --}}
                                    {{-- <li class="nav-item">
                                    <a href="{{ route('orders.create') }}" class="nav-link">
                                        <i class="fas fa-plus-circle nav-icon"></i>
                                        <p>create</p>
                                    </a>
                                </li> --}}
                                    {{-- @endcan --}}


                                </ul>
                            </li>
                        @endcan

                        {{-- @endcanany --}}
                        {{-- @endcanany --}}


                        <li class="nav-header">SETTINGS</li>
                        <li class="nav-item">
                            <a href="{{ route('mobile.changepass') }}" class="nav-link">
                                <i class="nav-icon fas fa-lock"></i>
                                <p> ChangePassword </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="modal" data-target="#modal-success"
                                href="{{ route('mobile.logout') }}">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p> Logout </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-large-name')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('page-small-name')</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                {{ env('APP_VERSION') }}
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2022-{{ now()->year + 1 }} <a
                    href="https://adminlte.io">{{ env('APP_NAME') }}</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <div class="modal fade" id="modal-success">
        <div class="modal-dialog">
            <div class="modal-content bg-success">
                <div class="modal-header">
                    <h4 class="modal-title">Are You Sure</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                    <a class="btn btn-outline-light" href="{{ route('mobile.logout') }}">Logout</i></a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('jss/sweet_alert.js') }}"></script>

    <!-- ChartJS -->
    <script src="{{ asset('cms/plugins/chart.js/Chart.min.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('jss/axios.js') }}"></script>

    <script src="{{ asset('jss/delete.js') }}"></script>

    <script src="{{ asset('jss/store.js') }}"></script>

    <script src="{{ asset('jss/update.js') }}"></script>

    <script src="{{ asset('jss/ajax.js') }}"></script>

    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
        $(document).ready(function() {
            $('.searchable-field').select2({
                theme: 'bootstrap4',
                // theme: 'classic',
                minimumInputLength: 3,
                ajax: {
                    url: '{{ route('globalSearch') }}',
                    dataType: 'json',
                    type: 'GET',
                    delay: 200,
                    data: function(term) {
                        return {
                            search: term
                        };
                    },
                    results: function(data) {
                        return {
                            data
                        };
                    }
                },
                escapMarkup: function(markup) {
                    return markup;
                },
                templateResult: formatItem,
                templateSelection: formatItemSelection,
                placeholder: '{{ trans('global.search') }}...',
                language: {
                    inputTooShort: function(args) {
                        var remainingChars = args.minimum - args.input.length;
                        var translation = '{{ trans('global.search_input_too_short') }}';

                        return translation.replace(':count', remainingChars);
                    },
                    errorLoading: function() {
                        return '{{ trans('global.results_could_not_be_loaded') }}';
                    },
                    searching: function() {
                        return '{{ trans('global.searching') }}';
                    },
                    noResults: function() {
                        return '{{ trans('global.no_results') }}'
                    },
                }
            });

            function formatItem(item) {
                if (item.loading) {
                    return '{{ trans('global.searching') }}...';
                }
                var markup = "<div class='searchable-link' href='" + item.url + "'>";
                markup = "<div class='searchable-title'>" + item.model;
                $.each(item.fields, function(key, field) {
                    markup += "<div class='searchable-fields'>" + item.fields_formated[field] + "</div>";
                });
                markup += "</div>";
                return markup;
            }

            function formatItemSelection(item) {
                if (!item.model) {
                    return '{{ trans('global.search') }}...';
                }
            }

        })
    </script>

    @yield('script')

</body>

</html>
