<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('browser_subtitle') | L'Oréal Group</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/colors.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{asset('assets/js/plugins/loaders/pace.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/core/libraries/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/core/libraries/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{asset('assets/js/plugins/forms/validation/validate.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/ui/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/pickers/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/notifications/sweet_alert.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/plugins/forms/selects/select2.min.js')}}"></script>

    <script type="text/javascript" src="{{asset('assets/js/core/app.js')}}"></script>
    <!-- /theme JS files -->

</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <span class="navbar-brand"><img src="{{asset('assets/images/logo_light.png')}}" alt=""></span>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <span>{{auth()->user()->name}}</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{url('admins/item/'.@auth()->user()->id)}}"><i class="icon-cog5"></i> Account settings</a>
                    </li>
                    <li><a href="{{url('logout')}}"><i class="icon-switch2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main">
            <div class="sidebar-content">

                <!-- Main navigation -->
                <div class="sidebar-category sidebar-category-visible">
                    <div class="category-content no-padding">
                        <ul class="navigation navigation-main navigation-accordion">

                            <li class="{{request()->is('admins*') ? 'active' : ''}}">
                                <a href="{{url('admins')}}"><i class="icon-users"></i><span>Admins</span></a>
                            </li>
                            <li class="{{request()->is('site*') ? 'active' : ''}}">
                                <a href="{{url('sites')}}"><i class="icon-city"></i><span>Sites</span></a>
                            </li>
                            <li class="{{request()->is('doors*') ? 'active' : ''}}">
                                <a href="{{url('doors')}}"><i class="icon-store2"></i><span>Doors</span></a>
                            </li>
                            <li class="{{request()->is('advisors*') ? 'active' : ''}}">
                                <a href="#"><i class="icon-man-woman"></i> <span>Beauty Advisors</span></a>
                                <ul>
                                    <li class="{{request()->is('advisors') ? 'active' : ''}}">
                                        <a href="{{url('advisors')}}">All Advisors</a></li>
                                    <li class="{{request()->is('advisors/attendance') ? 'active' : ''}}">
                                        <a href="{{url('advisors/attendance')}}">Attendance</a></li>
                                </ul>
                            </li>

                            <li class="{{request()->is('customers*') ? 'active' : ''}}">
                                <a href="{{url('customers')}}"><i class="icon-user"></i><span>Customers</span></a>
                            </li>

                            <li class="{{request()->is('categories*') ? 'active' : ''}}">
                                <a href="{{url('categories')}}"><i class="icon-tree6"></i><span>Categories</span></a>
                            </li>
                            <li class="{{request()->is('products/*', 'variations/*') ? 'active' : ''}}">
                                <a href="#"><i class="icon-box"></i> <span>Products</span></a>
                                <ul>
                                    <li class="{{request()->is('products*') ? 'active' : ''}}">
                                        <a href="{{url('products')}}">Products</a></li>
                                    <li class="{{request()->is('variations*') ? 'active' : ''}}">
                                        <a href="{{url('variations')}}">Variations</a></li>
                                </ul>
                            </li>
                            <li class="{{request()->is('reports') ? 'active' : ''}}">
                                <a href="{{url('reports')}}"><i class="icon-cart2"></i><span>Orders</span></a>
                            </li>
                             <li class="{{request()->is('stock*') ? 'active' : ''}}">
                                <a href="{{url('stock')}}"><i class="icon-table"></i><span>Stock</span></a>
                            </li>
                            <li class="{{request()->is('reports/*') ? 'active' : ''}}">
                                <a href="#"><i class="icon-pie-chart3"></i> <span>Reports</span></a>
                                <ul>
                                    <li class="{{request()->is('reports/sales/products') ? 'active' : ''}}">
                                        <a href="{{url('reports/sales/products')}}">By Product</a></li>
                                    <li class="{{request()->is('reports/sales/categories') ? 'active' : ''}}">
                                        <a href="{{url('reports/sales/categories')}}">By Category</a></li>
                                    <li class="{{request()->is('reports/sales/doors') ? 'active' : ''}}">
                                        <a href="{{url('reports/sales/doors')}}">By Door</a></li>
                                    <li class="{{request()->is('reports/sales/advisors') ? 'active' : ''}}">
                                        <a href="{{url('reports/sales/advisors')}}">By Advisor</a></li>
                                        <li class="{{request()->is('reports/sales/brands') ? 'active' : ''}}">
                                            <a href="{{url('reports/sales/brands')}}">By Brand</a></li>
                                </ul>
                            </li>
                            <li class="{{request()->is('complains*') ? 'active' : ''}}">
                                <a href="{{url('complains')}}"><i class="icon-bubble-notification"></i><span>Complains</span></a>
                            </li>
                            <li class="{{request()->is('wikis*') ? 'active' : ''}}">
                                <a href="{{url('wikis')}}"><i class="icon-help"></i><span>Wiki</span></a>
                            </li>
                            <li class="{{request()->is('settings*') ? 'active' : ''}}">
                                <a href="{{url('settings')}}"><i class="icon-cogs"></i><span>Settings</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /main navigation -->

            </div>
        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            @yield('body')

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>
