<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KFUEIT-MIS | <?php echo @$title ?></title>

    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/chart/css/main.css"/>
      <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/datatables/dataTables.bootstrap.css">
      <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/datatables/buttons.dataTables.min.css">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
      <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/font-awesome.min.css">
      <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/ionicons.min.css">

    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
      <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/bootstrap-datetime-picker/bootstrap-datetimepicker.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/calander.css">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/structure.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <!--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>-->
        <!--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>-->
    <![endif]-->
      <link rel="stylesheet" href="<?php echo base_url('assets') ?>/validation/css/validationEngine.jquery.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/chart/css/jquery.jOrgChart.css"/>
    <?php if(!empty($css)&& (is_array($css)||is_object($css))){
      foreach ($css as $cs)
      {
        echo '<link rel="stylesheet" href="'.base_url('assets')."/$cs".'" type="text/css"/>';
      }
    }
    ?>
      <script>
          var BASE_URL='<?php echo base_url() ?>';
      </script>

  </head>

    <body class="hold-transition skin-blue-light sidebar-collapse">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url('cms'); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>KFUEIT</b> MIS</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->

              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><?php echo @$this->session->userdata('username') ?></span>
                    <i class="fa pull-right fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <p>
                        <?php echo @$this->session->userdata('user_name') ?>
                      <small>Member since <?php echo mdate('%M. %Y',strtotime(@$this->session->userdata('joining_date'))) ?> </small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left" style="display: none">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <?php
                    if(!@$this->session->userdata('ldap'))
                    {
                      ?>

                      <div class="pull-left">
                        <a href="<?php echo base_url('changePass') ?>" class="btn btn-default btn-info">Change Password</a>
                      </div>

                      <?php
                    }
                    ?>
                    <div class="pull-right">
                      <a href="<?php echo base_url('logout') ?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <div id="loader" style="display: none"></div>
