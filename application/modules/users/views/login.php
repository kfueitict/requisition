<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KFUEIT | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/ionicons.min.css">
    <!-- Ionicons -->
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">

  <div class="login-box">
      <!-- /.login-logo -->
      <div class="login-logo">
          <a href="<?php echo base_url() ?>"><img style="width: 100%;" src="<?php echo base_url('assets/img/logo.png') ?>" alt="kfueit"></a>
      </div>
      <div class="login-box-body">
      <?php if($this->session->flashdata('message'))
      {?>
      <div class="box-body">
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('message') ;?>
                  </div>
        </div>
      <?php }
       ?>
      
        <p class="login-box-msg">Sign in to start your session</p>
        <form action="<?php echo base_url('users/login') ?>" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="User ID" name="email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            
<!--            <div class="col-xs-4">-->
<!--                <a href="--><?php //echo base_url('registration') ?><!--" class="btn btn-primary btn-block btn-flat">Register</a>-->
<!--                </div>-->
                <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

<a href="#">I forgot my password</a><br>
        

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url('assets') ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url('assets') ?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url('assets') ?>/plugins/iCheck/icheck.min.js"></script>
  </body>
</html>
