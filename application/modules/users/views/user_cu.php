<?php $this->load->view('include/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('users') ?>"><i class="fa fa-users"></i>Users</a></li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-user"></i>
                <h3 class="box-title"></h3>
                <button type="button" onclick="window.location.href='<?php echo base_url('users')?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post">
                <input type="hidden" value="<?php echo @$user->id ?>" name="update_id">
                <input type="hidden" id="tbl" value="users">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="user_id">User Name</label>
                        <div class="col-sm-6">
                            <input type="text" required=""
                                   class="form-control validate[<?php if(strlen(@$user->user_id)<1) echo 'ajax[ajaxUserID]'; ?>]"
                            <?php if(strlen( trim(@$user->user_id))>0) echo 'readonly'; ?>
                                   value="<?php echo @$user->user_id ?>"
                                   id="user_id"
                                   name="user_id"
                                   placeholder="User Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="first_name">First Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"
                                   value="<?php echo @$user->first_name ?>"
                                   id="first_name"
                                   name="first_name"
                                   placeholder="First Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="last_name">Last Name</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"
                                   value="<?php echo @$user->last_name ?>"
                                   id="last_name"
                                   name="last_name"
                                   placeholder="Last Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label required"  for="email">Email</label>
                        <div class="col-sm-6">
                            <input type="email" required=""
                                   class="form-control validate[custom[email]<?php if(strlen(@$user->user_id)<1) echo ',ajax[ajaxUserCallPhp]'; ?>]" <?php if(strlen(@$user->user_id)>1) echo 'readonly'; ?>
                                   value="<?php echo @$user->email ?>"
                                   id="email"
                                   name="email"
                                   placeholder="Email">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label required"  for="user_type">User Type</label>
                        <div class="col-sm-6">
                            <select class="form-control" required="" id="user_type" name="user_type">
                                <option value="">Select User Type</option>
                                <?php
                                if(is_array(@$types)||is_object(@$types))
                                foreach(@$types as $type)
                                {
                                    $select='';
                                    if(@$user->user_type==$type->id)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$type->id.'"  >'.$type->title.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3  control-label required"  for="user_access">User Access</label>
                        <div class="col-sm-6">
                            <?php

                            if(is_array(@$departments)||is_object(@$departments))
                            {
                                $depts=explode(',',@$user->departments);

                                foreach($departments as $dept)
                                {
                                    $check='';
                                    if(in_array($dept->id,$depts))
                                        $check='checked';
                                    echo '<label class="checkbox-inline"  for="'.$dept->slug.'"><input name="departments[]" id="'.$dept->slug.'" type="checkbox" '.$check.' value="'.$dept->id.'">'.$dept->title.'</label>';
                                }
                            }

                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="emp_id">Employee ID</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"
                                   value="<?php echo @$user->emp_id ?>"
                                   id="emp_id"
                                   name="emp_id"
                                   placeholder="Employee ID">
                        </div>
                    </div>
                    <?php if( isset($user)){ ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="password">Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control validate[minSize[4],equals[con-password]]"
                                   id="password"
                                   name="password"
                                   placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="con-password">Confirm Password</label>
                        <div class="col-sm-6">
                            <input type="password"  class="form-control validate[equals[password]]"
                                   id="con-password"
                                   name="con-password"
                                   placeholder="Confirm Password">
                        </div>
                    </div>
                    <?php }else{
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label required"  for="password">Password</label>
                            <div class="col-sm-6">
                                <input type="password" required="" class="form-control validate[minSize[4]]"
                                       id="password"
                                       name="password"
                                       placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label required"  for="con-password">Confirm Password</label>
                            <div class="col-sm-6">
                                <input type="password" required="" class="form-control validate[equals[password]]"
                                       id="con-password"
                                       name="con-password"
                                       placeholder="Confirm Password">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="radio">
                        <label for="status-active">Active
                            <input type="radio" id="status-active" name="status" class="minimal" value="1" checked>
                        </label>
                        <label for="status-block">Block
                            <input type="radio" id="status-block" name="status" class="minimal-red" value="0">
                        </label>
                            </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-success"><?php echo @$button ?></button>
                        </div>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->


    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer'); ?>
<script>
    $(function () {
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
    });
</script>
<script>
    $(document).ready(function(){


        $("#form1").validationEngine(
        );
    });
</script>