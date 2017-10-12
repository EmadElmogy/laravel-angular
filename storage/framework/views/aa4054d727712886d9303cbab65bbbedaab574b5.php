<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('browser_subtitle'); ?> | Laravel Angular Task</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/icons/icomoon/styles.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/bootstrap.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/core.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/components.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(asset('assets/css/colors.css')); ?>" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/loaders/pace.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/core/libraries/jquery.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/core/libraries/bootstrap.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/loaders/blockui.min.js')); ?>"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/forms/validation/validate.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/forms/styling/switchery.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/forms/styling/uniform.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/forms/selects/bootstrap_multiselect.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/ui/moment/moment.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/pickers/daterangepicker.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/notifications/sweet_alert.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/notifications/sweet_alert.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/plugins/forms/selects/select2.min.js')); ?>"></script>

    <script type="text/javascript" src="<?php echo e(asset('assets/js/core/app.js')); ?>"></script>
    <!-- /theme JS files -->

</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-inverse">
    <div class="navbar-header">
        <span class="navbar-brand">
          <!-- <img src="<?php echo e(asset('assets/images/logo_light.png')); ?>" alt=""> -->
        <div style="
        font-weight: bold;
        font-style: italic;
        font-family: cursive;
        font-size: x-large;"
        >
          Admin Dashboard
        </div>
        </span>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <span><?php echo e(auth()->user()->name); ?></span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="<?php echo e(url('admins/item/'.@auth()->user()->id)); ?>"><i class="icon-cog5"></i> Account settings</a>
                    </li>
                    <li><a href="<?php echo e(url('logout')); ?>"><i class="icon-switch2"></i> Logout</a></li>
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

                            <li class="<?php echo e(request()->is('admins*') ? 'active' : ''); ?>">
                                <a href="<?php echo e(url('admins')); ?>"><i class="icon-users"></i><span>Admins</span></a>
                            </li>

                            <li class="<?php echo e(request()->is('contacts*') ? 'active' : ''); ?>">
                                <a href="<?php echo e(url('contacts')); ?>"><i class="icon-user"></i><span>Contacts</span></a>
                            </li>

                            <li class="<?php echo e(request()->is('apartments*') ? 'active' : ''); ?>">
                                <a href="<?php echo e(url('apartments')); ?>"><i class="icon-home"></i><span>Apartments</span></a>
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

            <?php echo $__env->yieldContent('body'); ?>

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

</body>
</html>
